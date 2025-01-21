<script setup lang="ts">
import { ref } from 'vue'
import { login } from '@features/authentication/services'
import { useI18n } from 'vue-i18n'

const {t} = useI18n();

const email= ref('')
const password = ref('')
const error = ref('')
const isLoading = ref(false)

async function handleLogin() {
  if (!email.value || !password.value) {
    error.value = t("features.authentication.login.errors.missingValues")
    return
  }

  isLoading.value = true
  error.value = ''

  try {
    const response = await fetch('http://localhost:8080/login.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })
    if (!response.ok) {
      throw new Error("features.authentication.login.failed")
    }

    login()

  } catch (err: any) {
    error.value = t(`${err.message}`) || t("features.authentication.login.errors.unknownError")
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <h1>{{ t("features.authentication.login.title") }}</h1>

  <div>
    <label>{{ t("features.authentication.login.labels.email") }}</label>
    <input type="email" v-model="email" />
  </div>

  <div>
    <label>{{ t("features.authentication.login.labels.password") }}</label>
    <input type="password" v-model="password" />
  </div>

  <button :disabled="isLoading" @click="handleLogin">
    {{ t("features.authentication.login.labels.login") }}
  </button>

  <p v-if="error" style="color:red">{{ error }}</p>
</template>

<style scoped>
</style>
