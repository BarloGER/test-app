import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import path from 'path';

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': path.resolve(__dirname, './src'),
      '@shared/components': path.resolve(
          __dirname,
          './src/shared/components'
      ),
      '@shared/configs': path.resolve(__dirname, './src/shared/configs'),
      '@shared/entities': path.resolve(__dirname, './src/shared/entities'),
      '@shared/locales': path.resolve(__dirname, './src/shared/locales'),
      '@shared/layouts': path.resolve(__dirname, './src/shared/layouts'),
      '@shared/utils': path.resolve(__dirname, './src/shared/utils'),

      '@features/authentication/components': path.resolve(
          __dirname,
          './src/features/authentication/components'
      ),
    },
  },
})
