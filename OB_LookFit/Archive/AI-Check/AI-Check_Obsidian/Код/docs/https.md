# Устанавливаем basic-ssl:
npm i -D @vitejs/plugin-basic-ssl

# Правим vite.config.js:
```
import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import basicSsl from '@vitejs/plugin-basic-ssl' // +
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [
    vue(), 
    vueDevTools(), 
    basicSsl() // +
  ], 
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
  server: { // +
    host: true,
    port: 5173,
    https: true,
  },
})
```

- `basicSsl()` — генерирует самоподписанный сертификат.
- `server.host = true` — слушаем все интерфейсы, виден по локальной сети.
- `server.https = true` — включаем HTTPS.

# Запускаем сервер
npm run dev

В консоли будут адреса вида:

- `https://localhost:5173/`
- `https://192.168.**.**:5173/`

Открывайте со смартфона `https://<ваш_локальный_IP>:5173`.