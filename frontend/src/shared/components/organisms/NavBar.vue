<script setup lang="ts">
  import { useI18n } from 'vue-i18n';
  import { authState, logout } from '@features/authentication/services'

  const { t, locale } = useI18n();

  const changeLanguage = (lang: string) => {
    locale.value = lang;
  };
</script>

<template>
  <nav>
    <router-link to="/">Home</router-link>

    <router-link v-if="!authState.isAuthenticated" to="/login">
      {{ t("shared.components.organisms.navBar.links.login") }}
    </router-link>
    <router-link v-if="!authState.isAuthenticated" to="/register">
      {{ t("shared.components.organisms.navBar.links.register") }}
    </router-link>

    <router-link v-else to="/dashboard">
      {{ t("shared.components.organisms.navBar.links.dashboard") }}
    </router-link>
    <button v-if="authState.isAuthenticated" @click="logout()">
      {{ t("shared.components.organisms.navBar.links.logout") }}
    </button>

    <select @change="changeLanguage($event.target.value)" class="language-switch">
      <option value="en" :selected="locale === 'en'">English</option>
      <option value="de" :selected="locale === 'de'">Deutsch</option>
    </select>
  </nav>
</template>

<style scoped>
  nav {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    font-size: large;
    margin-right: 1rem;
    gap: 1rem;
  }

  router-link {
    text-decoration: none;
    margin-right: 1rem;
  }
</style>
