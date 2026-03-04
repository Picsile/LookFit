import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import tailwindcss from '@tailwindcss/vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue(), vueDevTools(), tailwindcss()],
  // server: {
  //   proxy: {
  //     // Все запросы, начинающиеся с /api, будут перенаправлены
  //     '/backend': {
  //       target: 'https://localhost.local', // Адрес твоего сервера
  //       // target: 'http://localhost', // Адрес твоего сервера
  //       changeOrigin: true,
  //     },
  //   },
  // },
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
})
