<script setup>
import snailImage from '../assets/snail.jpg'
</script>

<template>
  <section class="content">
    <img :src="snailImage" alt="Logo" class="main-logo" />
    <button class="start-button">Start Now</button>
  </section>
</template>

<style scoped>
.content {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  flex: 1;
  padding: 20px;
  width: 100%;
  background: inherit; 
  color: inherit; 
}
.main-logo {
  width: 150px; 
  margin-bottom: 20px;
}
.start-button {
  background-color: orange;
  color: black;
  border: none;
  padding: 12px 24px;
  font-size: 16px;
  border-radius: 5px;
  cursor: pointer;
  margin-bottom: 20px; 
}
.start-button:hover {
  background-color: darkorange;
}
</style>