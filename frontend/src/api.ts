import axios from 'axios'

export const TOKEN_KEY = 'token'

// Фронт и API на одном домене, поэтому достаточно относительного пути
const api = axios.create({
  baseURL: '/api',
  headers: {
    Accept: 'application/json',
  },
})

// Подставляем токен из localStorage в каждый запрос
api.interceptors.request.use((config) => {
  const token = localStorage.getItem(TOKEN_KEY)

  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }

  return config
})

export default api
