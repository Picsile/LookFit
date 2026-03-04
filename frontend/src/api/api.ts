import axios from 'axios'

const api = axios.create({
  baseURL: 'https://localhost.local/backend',
  // baseURL: '/backend',
})

api.interceptors.request.use((config) => {
  // Автоматически подставляем токен
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  if (!('Content-Type' in config.headers)) {
    config.headers['Content-Type'] = 'application/json'
  }

  return config
})

export const guestApi = {
  async getSomePosts() {
    const response = await api.post('/site/get-some-posts')
    return response.data
  },
}

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

export const accountApi = {
  async publicThing(formData: FormData) {
    const response = await api.post('/account/post/public-thing', formData, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })
    return response.data
  },
}

export default api
