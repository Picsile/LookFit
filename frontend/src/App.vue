<script setup lang="ts">
import { onMounted, reactive } from 'vue'
import { useUserStore } from '@/stores/user'
import { authApi } from './api/api'
import Header from './components/Header.vue'
import Navbar from './components/Navbar.vue'

const userStore = useUserStore()

onMounted(async () => {
  const token: string | null = localStorage.getItem('token')

  if (token) {
    const data = await authApi.findByToken(token)

    if (data.status == 'success') {
      userStore.setUser(data.user)
    }
  }
})
</script>

<template>
  <Header v-if="!$route.meta.hideHeader" :hideBoards="$route.meta.hideBoards" />
  <Navbar v-if="!$route.meta.hideNavbar" />

  <router-view />
</template>

<style scoped></style>
