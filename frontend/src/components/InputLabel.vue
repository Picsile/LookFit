<script setup lang="ts">
const props = defineProps<{
  name: string
  type: 'text' | 'email' | 'password'
  modelValue: string

  label: string
  placeholder: string
  errorMessage?: string
}>()

const emit = defineEmits<{
  (e: 'update:modelValue', value: string): void
  (e: 'blur', ev: Event): void
}>()

const inputId = 'input-' + Math.floor(Math.random() * 1000)
</script>

<template>
  <div>
    <label :for="inputId" class="relative w-full">
      <input
        :id="inputId"
        :name="name"
        :type="type"
        :value="modelValue"
        @input="emit('update:modelValue', $event.target.value)"
        @blur="emit('blur', $event)"
        :placeholder="placeholder"
        class="w-full px-5 py-2.5 border border-black rounded-xl peer focus:border-indigo-500 focus:outline-none"
        required
      />

      <span
        class="label absolute top-1/2 left-3 bg-(--color-main-panel) px-2 -translate-y-1/2 peer-focus:-translate-y-8.5 peer-valid:-translate-y-8.5 peer-focus:text-indigo-500 peer-focus:scale-85 peer-valid:scale-85 transition-transform origin-left"
        >{{ label }}</span
      >
    </label>

    <div v-if="errorMessage" class="errorMessage text-sm text-red-500 mt-1 -mb-3">
      <span>{{ errorMessage }}</span>
    </div>
  </div>
</template>

<style scoped>
.label {
  border-radius: 100% 100% 0 0;
}
</style>
