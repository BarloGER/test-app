import { createWebHistory, createRouter } from 'vue-router'

//TODO: Import error beseitigen
import {LandingPage} from "@shared/components/pages";
import {LoginPage, RegisterPage} from '@features/authentication/components/pages'

const routes = [
    { path: '/', component: LandingPage },
    { path: '/login', component: LoginPage },
    { path: '/register', component: RegisterPage },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})