<script setup lang="ts">
  import { login } from '@features/authentication/services'

  function handleLogin() {
    login()
  }
</script>

<template>
  <h1>Login</h1>
  <button @click="handleLogin">Login</button>
</template>

<style scoped>

</style>