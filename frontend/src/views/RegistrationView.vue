<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { isAxiosError } from 'axios'
import api, { TOKEN_KEY } from '@/api'
import type { Gender } from '@/types'

const router = useRouter()

const form = reactive({
  email: '',
  password: '',
  gender: '' as Gender | '',
})

const errors = ref<Record<string, string>>({})
const showPassword = ref(false)
const loading = ref(false)

const EMAIL_REGEX = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

function validate(): boolean {
  errors.value = {}

  if (!EMAIL_REGEX.test(form.email)) {
    errors.value.email = 'Введите корректный email'
  }
  if (form.password.length < 8) {
    errors.value.password = 'Пароль должен быть не короче 8 символов'
  }
  if (!form.gender) {
    errors.value.gender = 'Выберите пол'
  }

  return Object.keys(errors.value).length === 0
}

async function submit() {
  if (!validate()) {
    return
  }

  loading.value = true

  // Выводим запрос в консоль до отправки, чтобы он был виден и при ошибке
  console.log('Запрос:', {
    method: 'POST',
    url: api.getUri({ url: '/registration' }),
    body: { ...form, password: '********' },
  })

  try {
    const response = await api.post('/registration', form)
    console.log('Ответ:', response.status, response.data)

    localStorage.setItem(TOKEN_KEY, response.data.token)
    router.push({ name: 'profile' })
  } catch (error) {
    if (isAxiosError(error)) {
      console.log('Ответ:', error.response?.status, error.response?.data)
    }

    // Laravel возвращает ошибки валидации со статусом 422 в виде { errors: { поле: [сообщения] } }
    if (isAxiosError(error) && error.response?.status === 422) {
      const serverErrors: Record<string, string[]> = error.response.data.errors

      for (const [field, messages] of Object.entries(serverErrors)) {
        errors.value[field] = messages[0] ?? ''
      }
    } else {
      errors.value.common = 'Не удалось выполнить запрос, попробуйте позже'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <form class="card" novalidate @submit.prevent="submit">
    <h1>Регистрация</h1>

    <div class="field">
      <label for="email">Email</label>
      <input
        id="email"
        v-model.trim="form.email"
        type="email"
        autocomplete="email"
        placeholder="you@example.com"
      />
      <div v-if="errors.email" class="error">{{ errors.email }}</div>
    </div>

    <div class="field">
      <label for="password">Пароль</label>
      <div class="password">
        <input
          id="password"
          v-model="form.password"
          :type="showPassword ? 'text' : 'password'"
          autocomplete="new-password"
          placeholder="Минимум 8 символов"
        />
        <button type="button" class="toggle" @click="showPassword = !showPassword">
          {{ showPassword ? 'Скрыть' : 'Показать' }}
        </button>
      </div>
      <div v-if="errors.password" class="error">{{ errors.password }}</div>
    </div>

    <div class="field">
      <label for="gender">Пол</label>
      <select id="gender" v-model="form.gender">
        <option value="" disabled>Выберите пол</option>
        <option value="male">Мужской</option>
        <option value="female">Женский</option>
      </select>
      <div v-if="errors.gender" class="error">{{ errors.gender }}</div>
    </div>

    <button type="submit" class="btn" :disabled="loading">
      {{ loading ? 'Отправка...' : 'Зарегистрироваться' }}
    </button>
    <div v-if="errors.common" class="error">{{ errors.common }}</div>
  </form>
</template>

<style scoped>
.field {
  margin-bottom: 16px;
}

label {
  display: block;
  margin-bottom: 6px;
  font-size: 14px;
}

input,
select {
  width: 100%;
  padding: 9px 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 15px;
  background: #fff;
}

.password {
  display: flex;
  gap: 8px;
}

.toggle {
  flex-shrink: 0;
  padding: 0 12px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background: #f4f5f7;
  cursor: pointer;
}
</style>
