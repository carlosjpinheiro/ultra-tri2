import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  base: '/',
  plugins: [vue()],
  server: { proxy: { '/site-api/v1': 'http://127.0.0.1:8001' } },
})
