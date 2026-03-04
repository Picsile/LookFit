<script setup lang="ts">
import { guestApi } from '@/api/api'
import HomePost from '@/components/HomePost.vue'
import LoaderCircle from '@/components/LoaderCircle.vue'
import { onMounted, reactive, ref } from 'vue'

const posts = ref<any[]>([])

const isLoad = ref<boolean>(false)

const getPosts = async () => {
  try {
    isLoad.value = true
    const data = await guestApi.getSomePosts()

    if (data.status == 'success') {
      // Получили данные
      posts.value = data.posts
      return
    }
  } catch (error) {
    console.error(error)
  } finally {
    isLoad.value = false
  }
}

onMounted(() => {
  getPosts()
})
</script>

<template>
  <div class="pl-[var(--w-navbar)] pt-32.5">
    <div class="px-4 pt-4">
      <div class="columns-7 gap-4">
        <HomePost v-for="post in posts" :key="post.id" :path="post.images[0]" />
      </div>
      <div>
        <LoaderCircle :is-load="isLoad" />
      </div>
    </div>
  </div>
</template>

<style scoped>
.home__post {
  overflow: hidden;
  break-inside: avoid;
  border-radius: 16px;
  margin-bottom: 16px;
}

.home__post img {
  filter: saturate(108%) contrast(108%);
  -webkit-filter: saturate(108%) contrast(108%);
  -moz-filter: saturate(108%) contrast(108%);
}
</style>
