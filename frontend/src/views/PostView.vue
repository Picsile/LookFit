<script setup lang="ts">
import ArrowBack from '@/components/ArrowBack.vue'
import { useUserStore } from '@/stores/user'
import { useRoute } from 'vue-router'

const route = useRoute()
const userStore = useUserStore()

const postId = route.params.postId
</script>

<template>
  <div class="pl-[var(--w-navbar)] pt-20.5">
    <div class="flex gap-4 px-4 pt-4">
      <div class="flex w-fit">
        <ArrowBack path="/" />
      </div>
      <!-- Post -->
      <div class="p-4 bg-(--color-main-panel) rounded-2xl">
        <div>
          <img :src="userStore.user?.avatar_path" alt="" />
        </div>
        <div>
          <img src="https://localhost.local/backend/uploads/Без названия (6).jpg" alt="" />
        </div>
        <div></div>
      </div>
    </div>
  </div>
</template>
