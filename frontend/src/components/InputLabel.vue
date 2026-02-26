<script setup lang="ts">
defineProps<{
  label: string
  placeholder: string
  type: 'text' | 'email' | 'password'
  modelValue: string
}>()

const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>()

const inputId = 'input-' + Math.floor(Math.random() * 100)
</script>

<template>
  <label :for="inputId" class="relative w-full">
    <input
      required
      :type="type"
      name=""
      :id="inputId"
      :placeholder="placeholder"
      class="w-full px-5 py-2.5 border border-black rounded-xl peer focus:border-indigo-500 focus:outline-none"
      :value="modelValue"
      @input="emit('update:modelValue', $event.target.value)"
    />

    <span
      class="absolute top-1/2 left-3 bg-(--color-main-panel) px-2 peer-placeholder-shown:-translate-y-1/2 peer-focus:-translate-y-8.5 peer-valid:-translate-y-8.5 peer-focus:text-indigo-500 peer-focus:scale-85 peer-valid:scale-85 transition-transform origin-left"
      >{{ label }}</span
    >
  </label>
</template>
