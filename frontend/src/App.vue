<script setup lang="ts"></script>

<template>
  <main class="container">
    <RouterView />
  </main>
</template>

<style>
* {
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: system-ui, sans-serif;
  background: #f4f5f7;
  color: #222;
}

.container {
  max-width: 420px;
  margin: 60px auto;
  padding: 0 16px;
}

.card {
  padding: 24px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
}

h1 {
  margin: 0 0 20px;
  font-size: 22px;
}

.btn {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 6px;
  background: #3b6fd8;
  color: #fff;
  font-size: 15px;
  cursor: pointer;
}

.btn:disabled {
  opacity: 0.6;
  cursor: default;
}

.error {
  margin-top: 4px;
  color: #d33;
  font-size: 13px;
}
</style>
