<script setup lang="ts">
defineProps<{
  isLoad: boolean
}>()
</script>

<template>
  <div
    class="loader absolute top-0 left-0 flex justify-center items-center w-full h-full bg-(--color-load) rounded-4xl"
    :class="{ hidden: !isLoad }"
  >
    <div
      class="border-5 border-(--color-hover-input) border-t-(--color-blue) w-14 h-14 rounded-full animate-spin opacity-60"
    ></div>
  </div>
</template>
