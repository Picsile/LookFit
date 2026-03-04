<script setup lang="ts">
defineProps<{
  path: string
}>()
</script>

<template>
  <div class="home__post">
    <img :src="path" alt="" />
  </div>
</template>
