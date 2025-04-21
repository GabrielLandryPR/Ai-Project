<script setup>
import snailImage from '../assets/snail.jpg'
</script>

<template>
  <header class="navbar">
    <img :src="snailImage" alt="Logo" class="logo" />
    <nav class="nav-links">
       <router-link to="/" class="nav-button">Accueil</router-link>
      <router-link to="/chat" class="nav-button">Chat</router-link>
      <button class="nav-button">Settings</button>
      <button class="nav-button">Language</button>
    </nav>
  </header>
</template>


<!-- import chatIcon from '../assets/Tchat.png'
import languageIcon from '../assets/Language.png'
import settingsIcon from '../assets/Settings.png' -->
  <!-- <div class="header-icons">
        <img class="icon" :src="chatIcon" alt="Tchat" />
        <img class="icon" :src="languageIcon" alt="Language" />
        <img class="icon" :src="settingsIcon" alt="Settings" />
  </div> -->


<style scoped>
.logo {
  width: 200px;
  height: auto;
  /* display: block;  <-- supprime cette ligne */
  vertical-align: middle;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: flex-start; /* Modifie center -> flex-start */
  padding: 10px 20px;
  background: #1d1c1c1a;
}

.nav-links {
  display: flex;
  gap: 16px;
  align-items: flex-start; /* Modifie center -> flex-start */
  align-self: flex-start;
  margin-top: 40px;  /* Ajoute cette ligne */
}

.nav-button {
  background-color: orange;
  color: black;
  border: none;
  padding: 16px 32px; /* Plus grand bouton */
  border-radius: 6px;
  cursor: pointer;
  text-decoration: none;
  font-size: 1.2rem; /* Texte plus grand */
  font-weight: bold;
  transition: background 0.2s;
}

.nav-button:hover {
  background-color: darkorange;
}

</style>
