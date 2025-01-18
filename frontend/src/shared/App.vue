<script setup lang="ts">
  import {NavBar} from "@shared/components/organisms";
</script>

<template>
  <header>
    <NavBar/>
  </header>
  <main>
    <router-view />
  </main>
</template>

<style scoped>
header {
  height: 50px;
}
</style>
