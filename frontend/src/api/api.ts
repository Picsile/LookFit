import axios from 'axios'

const api = axios.create({
  baseURL: 'https://localhost.local/backend',
})

// Автоматически подставляем токен
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  if (config.data instanceof FormData) {
    delete config.headers['Content-Type']
  } else {
    config.headers['Content-Type'] = 'application/json'
  }

  return config
})

export const authApi = {
  async login(formData: any) {
    const response = await api.post('/site/login', formData)
    return response.data
  },

  async register(formData: any) {
    const response = await api.post('/site/register', formData)
    return response.data
  },

  async findByToken(token: string) {
    const response = await api.get('/site/find-by-token', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    return response.data
  },

  async logout() {
    const response = await api.get('/site/logout')
    localStorage.removeItem('token')
    return response.data
  },
}

export const userApi = {
  async publicThing(formData: FormData) {
    const response = await api.post('/account/public-thing', formData)
    return response.data
  },
}

export default api
