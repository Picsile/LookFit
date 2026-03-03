<script setup lang="ts">
import IconArrowBack from './icons/IconArrowBack.vue'

const props = defineProps<{
  path: string
  query?: string
}>()
</script>

<template>
  <router-link :to="path" class="btn-default bg-(--color-main-panel)">
    <IconArrowBack />
  </router-link>
</template>
