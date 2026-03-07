<script setup lang="ts">
import { guestApi } from '@/api/api'
import HomePost from '@/components/HomePost.vue'
import LoaderCircle from '@/components/LoaderCircle.vue'
import { onMounted, ref } from 'vue'

const posts = ref<any[]>([])

const isLoad = ref<boolean>(false)

const getPosts = async () => {
  try {
    isLoad.value = true
    const data = await guestApi.getSomePosts()
console.log(data);

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
        <HomePost v-for="post in posts" :key="post.id" :post-id="post.id" :path="post.images[0]" />
      </div>
      <div>
        <LoaderCircle :is-load="isLoad" />
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
