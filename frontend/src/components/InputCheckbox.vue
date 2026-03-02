<script setup lang="ts">
const props = defineProps<{
  name: string
  modelValue: boolean
  label: string
  errorMessage?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: boolean): void
  (e: 'blur', ev: Event): void
}>()

const inputId = 'checkbox-' + Math.floor(Math.random() * 100000)
</script>

<template>
  <div class="flex flex-col">
    <label :for="inputId" class="flex items-center gap-2 cursor-pointer">
      <input
        :id="inputId"
        type="checkbox"
        :name="name"
        :checked="modelValue"
        @change="emit('update:modelValue', $event.target.checked)"
        @blur="emit('blur', $event)"
        class="w-4 h-4"
      />

      <span>{{ label }}</span>
    </label>

    <div v-if="errorMessage" class="text-sm text-red-500">
      {{ errorMessage }}
    </div>
  </div>
</template>
