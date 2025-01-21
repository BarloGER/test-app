<script setup lang="ts">
import { ref } from 'vue'
import { useI18n } from 'vue-i18n'

const {t} = useI18n();

const username = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

const error = ref('')
const success = ref('')
const isLoading = ref(false)


async function handleRegister() {
    if (!username.value || !email.value || !password.value || !passwordConfirm.value) {
    error.value = t("features.authentication.register.errors.missingValues")
    return
  }
  if (password.value !== passwordConfirm.value) {
    error.value = t("features.authentication.register.errors.passwordMatch")
    return
  }

  isLoading.value = true
  error.value = ''
  success.value = ''

  try {
    const response = await fetch('http://localhost:8080/register.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        username: username.value,
        email: email.value,
        password: password.value
      })
    })

    if (!response.ok) {
      throw new Error(t("features.authentication.register.failed"))
    }

    success.value = t("features.authentication.register.success")

  } catch (err: any) {
    error.value = t(`${err.message}`) || t("features.authentication.register.errors.unknownError")
  } finally {
    isLoading.value = false
  }
}
</script>

<template>
  <h1>{{ t("features.authentication.register.title") }}</h1>

  <div>
    <label>{{ t("features.authentication.register.labels.username") }}</label>
    <input type="text" v-model="username" />
  </div>

  <div>
    <label>{{ t("features.authentication.register.labels.email") }}</label>
    <input type="email" v-model="email" />
  </div>

  <div>
    <label>{{ t("features.authentication.register.labels.password") }}</label>
    <input type="password" v-model="password" />
  </div>

  <div>
    <label>{{ t("features.authentication.register.labels.repeatPassword") }}</label>
    <input type="password" v-model="passwordConfirm" />
  </div>

  <button :disabled="isLoading" @click="handleRegister">
    Registrieren
  </button>

  <p v-if="error" style="color:red">{{ error }}</p>
  <p v-if="success" style="color:green">{{ success }}</p>
</template>

<style scoped>
</style>
