<script setup lang="ts">
const props = defineProps<{
  name: string
  type: 'text'
  modelValue?: string

  label: string
  placeholder?: string
  errorMessage?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
  (e: 'blur', ev: Event): void
}>()

const inputId = 'input-' + Math.floor(Math.random() * 1000)
</script>

<template>
  <div class="group flex flex-col">
    <label class="text-base mb-0.5 group-focus-within:text-indigo-500">
      {{ label }}
    </label>

    <textarea
      :id="inputId"
      :name="name"
      :type="type"
      :value="modelValue"
      @input="emit('update:modelValue', $event.target.value)"
      @blur="emit('blur', $event)"
      :placeholder="placeholder"
      class="w-full h-27 bg-(--color-input) px-5 py-2.5 rounded-2xl hover:bg-(--color-hover-input) focus:outline focus:outline-indigo-500"
    />

    <div v-if="errorMessage" class="text-sm text-red-500 mt-1 -mb-3">
      {{ errorMessage }}
    </div>
  </div>
</template>
