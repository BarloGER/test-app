<script setup lang="ts">
  import { useI18n } from 'vue-i18n';

  const { t } = useI18n();
</script>

<template>
  <nav>
    <router-link to="/">Home</router-link>
    <router-link to="/login">{{ t("shared.components.organisms.navBar.links.login") }}</router-link>
    <router-link to="/register">{{ t("shared.components.organisms.navBar.links.register") }}</router-link>
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
