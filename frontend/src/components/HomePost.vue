<script setup lang="ts">
import router from '@/router'

defineProps<{
  postId: number
  path: string
}>()
</script>

<template>
  <router-link :to="`/post/${postId}`">
    <div class="home__post overflow-hidden break-inside-avoid rounded-2xl mb-4">
      <img :src="path" alt="" />
    </div>
  </router-link>
</template>

<style scoped>
.home__post img {
  filter: saturate(105%) contrast(105%);
}

.home__post:hover img {
  filter: brightness(60%);
}
</style>
