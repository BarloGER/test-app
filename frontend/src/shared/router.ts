import { createWebHistory, createRouter } from 'vue-router'
import { useAuthState } from '@features/authentication/services'
//TODO: Import error beseitigen
import {LandingPage, DashboardPage} from "@shared/components/pages";
import {LoginPage, RegisterPage} from '@features/authentication/components/pages'

const routes = [
    {
        path: '/',
        name: 'home',
        component: LandingPage
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterPage
    },

    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardPage,
        meta: { requiresAuth: true },
    }
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

// Global navigation guard
router.beforeEach((to, from, next) => {
    const authState = useAuthState()

    if (to.meta.requiresAuth && !authState.isAuthenticated) {
        next({ name: 'login' })
    } else {
        next()
    }
})