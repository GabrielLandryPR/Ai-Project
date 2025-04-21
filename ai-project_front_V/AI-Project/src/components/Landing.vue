<template>
  <div class="landing-container">

       <navbar />

    <main class="landing-main">
      <h1 class="title">AI-Project</h1>
      <p class="subtitle">AI DOES THE WORK, YOU CALL THE SHOTS.</p>

      <div class="search-container">
        <input type="text" class="search-input" placeholder="Write here" v-model="searchText" />
        <button class="go-button" @click="handleGoClick">GO</button>
      </div>

      <div v-if="chatResponse" class="response-container">
        <h2>Réponse de l'API :</h2>
        <pre>{{ chatResponse }}</pre>
      </div>
    </main>

    <footer class="landing-footer">
      <div class="copy-right">
        <p>© 2021 Snail Mail</p>
      </div>

      <div class="social-icons">
        <img :src="instagramIcon" alt="Instagram" />
        <img :src="facebookIcon" alt="Facebook" />
        <img :src="xIcon" alt="X / Twitter" />
        <img :src="linkedinIcon" alt="LinkedIn" />
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axiosInstance from '@/axios/instance' 

import navbar from './Navbar.vue' 


import instagramIcon from '../assets/instagram.png'
import facebookIcon from '../assets/facebook.png'
import xIcon from '../assets/X.avif'
import linkedinIcon from '../assets/linkedin.png'

const searchText = ref('')
const chatResponse = ref('')

const handleGoClick = () => {
  // Vérifier qu'un texte a été saisi
  const prompt = searchText.value.trim() || "Donne-moi une blague sur le développement Java."

  // Appel à l'API
  axiosInstance.get('ai/chat', { params: { prompt } })
    .then(response => {
      let data = response.data

      // Extraire la propriété "response" de l'objet reçu
      if (data && data.response) {
        // Assigner directement la valeur de data.response
        chatResponse.value = data.response
      } else {
        console.error("Format de réponse inattendu:", data)
        chatResponse.value = "Erreur: Format de réponse inattendu"
      }
    })
    .catch(error => {
      console.error("Erreur de requête:", error)
      chatResponse.value = "Erreur de communication avec l'API"
    })
}
</script>

<style scoped>
/* Conteneur principal qui occupe toute la page */
.landing-container {
  background-color: #121212; /* Fond noir */
  min-height: 100vh;         /* Occupe toute la hauteur */
  display: flex;
  flex-direction: column;
  font-family: "Arial", sans-serif;
  margin: 0;
  padding: 0;
}

.copy-right {
  color: #FF9C38; 
}

/* HEADER */
.landing-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
}

.logo {
  width: 100px;
  height: auto;
}

.header-icons {
  display: flex;
  gap: 20px;
}

.icon {
  width: 32px;
  height: 32px;
  cursor: pointer;
}

/* SECTION CENTRALE */
.landing-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
}

.title {
  font-size: 4rem;
  font-weight: 900;
  color: #FF9C38;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin: 0;
  margin-bottom: 10px;
  -webkit-text-stroke: 1px #000;
  text-shadow: -1px 0 #000, 0 1px #000, 1px 0 #000, 0 -1px #000;
}

.subtitle {
  font-size: 1.2rem;
  color: #FF9C38;
  margin-bottom: 40px;
}

/* Barre de recherche */
.search-container {
  position: relative;
  width: 70%;
  height: 60px;
  background-color: #FF9C38;
  border-radius: 50px;
  display: flex;
  justify-content: center; 
  align-items: center;
  padding: 10px 20px;
  margin-top: 50px;
}

.search-input {
  width: 100%;
  height: 100%;
  background-color: #FF9C38;
  border: none;
  border-radius: 50px;
  padding: 0 20px;
  font-size: 1.2rem;
  color: #000;
  font-weight: bold;
  text-align: center;
  outline: none;
  box-shadow: none;
}

.search-input::placeholder {
  color: #000;
  opacity: 1;
}

.go-button {
  position: absolute;
  right: 10px;
  background-color: transparent;
  border: none;
  font-size: 1rem;
  color: #000;
  font-weight: bold;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  background-image: url('../assets/Play.png');
  background-size: 60px 60px;
  background-repeat: no-repeat;
  background-position: center;
  width: 60px;
  height: 60px;
  padding: 0;
  padding-right: 10px;
}

/* PIED DE PAGE */
.landing-footer {
  display: flex;
  justify-content: center;
  padding: 20px;
  margin-top: auto;
}

.social-icons {
  display: flex;
  gap: 20px;
}

.social-icons img {
  width: 24px;
  height: 24px;
  cursor: pointer;
}

/* Zone de réponse */
.response-container {
  margin-top: 30px;
  color: #FF9C38;
  text-align: center;
  white-space: pre-wrap;
}
</style>
