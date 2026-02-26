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

export const useUserStore = defineStore('user', () => {
  const isAccount = ref(false)

  const user = ref<User | null>(null)

  async function checkToken() {
    if (user.value) return

    const token = localStorage.getItem('token')

    if (!token) return

    const response = await fetch('http://localhost/backend/site/find-by-token', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    const result = await response.json()

    if (result.status == 'success') {
      isAccount.value = true
      user.value = result.user
    }
  }

  function logout() {
    fetch(`https://lookfit.local/backend/site/logout`)
    isAccount.value = false
    user.value = null
    localStorage.setItem('token', '')
  }

  return {
    isAccount,
    user,
    checkToken,
    logout,
  }
})
