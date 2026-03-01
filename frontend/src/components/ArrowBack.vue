<script setup lang="ts">
import IconArrowBack from './icons/IconArrowBack.vue'

const props = defineProps<{
  path: string
  query?: string
}>()
</script>

<template>
  <route-link :to="path" class="btn-default bg-(--color-main-panel)">
    <IconArrowBack />
  </route-link>
</template>
