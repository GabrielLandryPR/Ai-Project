<script setup>
import Navbar from '../components/Navbar.vue'
import Home from '../components/Home.vue'
import Footer from '../components/Footer.vue'
</script>

<template>
  <div class="home-container">
    <Navbar/>
    <div class="content-wrapper">
      <Home/>
    </div>
    <Footer/>
  </div>
</template>

<style scoped>
.home-container {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  width: 100%;
  background: #1d1c1c; /* Fond noir */
  color: white;
}

.content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
</style>