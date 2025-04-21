import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LandingView from '../views/LandingView.vue'


const routes = [
  { path: '/', name: 'home', component: HomeView },
  { path: '/chat', name: 'landing', component: LandingView },

]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
