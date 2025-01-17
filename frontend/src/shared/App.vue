<script setup lang="ts">
</script>

<template>
  <header>
    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/about">About</router-link>
    </nav>
  </header>
  <main>
    <router-view />
  </main>
</template>

<style scoped>
header {
  height: 50px;
}

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
