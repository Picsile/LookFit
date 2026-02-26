<script setup lang="ts">
import { onMounted, reactive } from 'vue'
import { useUserStore } from '@/stores/user'
import { authApi } from './api/api'

const userStore = useUserStore()

onMounted(async () => {
  const token: string | null = localStorage.getItem('token')
  if (token) {
    const user = await authApi.findByToken(token)
    console.log(user)
  }
})
</script>

<template>
  <router-view />
</template>

<style scoped></style>
