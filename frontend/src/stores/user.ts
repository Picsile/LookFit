import { defineStore } from 'pinia'
import { reactive, ref } from 'vue'

interface User {
  id: number
  username: string
  login: string
  email: string
  phone: string | null
  avatar_path: string
  background_path: string
  role_id: number
  auth_key: string
}

export const useUserStore = defineStore('user', {
  state: () => {
    return {
      user: null as User | null,
      isAccount: false as boolean,
      isAdmin: false as boolean,
    }
  },

  actions: {
    setUser(userData: User) {
      this.user = userData
      if (userData) this.isAccount = true
      if (userData.role_id == 2) this.isAdmin = true
    },
    clearUser() {
      this.user = null
      this.isAccount = false
      this.isAdmin = false
    },
  },
})
