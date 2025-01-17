import { createWebHistory, createRouter } from 'vue-router'

import HomeView from '../components/HomeView.vue'
import AboutView from '../components/AboutView.vue'

const routes = [
    { path: '/', component: HomeView },
    { path: '/about', component: AboutView },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})