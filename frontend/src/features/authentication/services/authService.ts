// src/auth/authState.ts
import { reactive } from 'vue'
import { router} from '../../../shared/router.ts'

// Sollte ich pinia nutzen?

export const authState = reactive({
    isAuthenticated: false,
    user: null
})

export function login(): void {
    authState.isAuthenticated = true
    router.push({name: 'dashboard'})
}

export function logout(): void {
    authState.isAuthenticated = false
    authState.user = null
    router.push({name: 'login'})
}

export function useAuthState() {
    return authState
}