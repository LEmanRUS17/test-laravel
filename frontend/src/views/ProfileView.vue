<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { isAxiosError } from 'axios'
import api, { TOKEN_KEY } from '@/api'
import type { User } from '@/types'

const router = useRouter()

const user = ref<User | null>(null)
const error = ref('')

const genderLabels = {
  male: 'Мужской',
  female: 'Женский',
}

function formatDate(value: string): string {
  return new Date(value).toLocaleString('ru-RU')
}

onMounted(async () => {
  try {
    const response = await api.get('/profile')
    user.value = response.data.data
  } catch (e) {
    // Нет токена или он недействителен — отправляем на регистрацию
    if (isAxiosError(e) && e.response?.status === 401) {
      localStorage.removeItem(TOKEN_KEY)
      router.push({ name: 'registration' })
      return
    }
    error.value = 'Не удалось загрузить профиль'
  }
})

function logout() {
  localStorage.removeItem(TOKEN_KEY)
  router.push({ name: 'registration' })
}
</script>

<template>
  <div class="card">
    <h1>Профиль</h1>

    <div v-if="error" class="error">{{ error }}</div>

    <template v-else-if="user">
      <dl>
        <dt>ID</dt>
        <dd>{{ user.id }}</dd>
        <dt>Email</dt>
        <dd>{{ user.email }}</dd>
        <dt>Пол</dt>
        <dd>{{ genderLabels[user.gender] }}</dd>
        <dt>Дата регистрации</dt>
        <dd>{{ formatDate(user.created_at) }}</dd>
        <dt>Дата обновления</dt>
        <dd>{{ formatDate(user.updated_at) }}</dd>
      </dl>

      <button class="btn" @click="logout">Выйти</button>
    </template>

    <p v-else>Загрузка...</p>
  </div>
</template>

<style scoped>
dl {
  margin: 0 0 20px;
}

dt {
  font-size: 13px;
  color: #777;
}

dd {
  margin: 2px 0 12px;
  font-size: 16px;
}
</style>
