import { defineStore } from 'pinia'
import axios from 'axios'
import router from '../router'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('token') || null,
    }),
    actions: {
        async login(email: string, password: string) {
            try {
                const response = await axios.post('/api/login', { email, password })
                this.token = response.data.data.token
                console.log("respons1e", response.data.data.token)
                console.log("respons3e", response.data.data)
                console.log("token", this.token)
                localStorage.setItem('token', this.token)
                axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
                router.push('/')
            } catch (error) {
                console.error('Login failed', error)
                throw error
            }
        },
        logout() {
            this.token = null
            localStorage.removeItem('token')
            axios.defaults.headers.common['Authorization'] = ''
            router.push('/login')
        },
    },
})
