import { createRouter, createWebHistory } from 'vue-router'
import RegistrationView from '@/views/RegistrationView.vue'
import ProfileView from '@/views/ProfileView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'registration',
      component: RegistrationView,
      meta: { title: 'Регистрация' },
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView,
      meta: { title: 'Профиль' },
    },
  ],
})

// Заголовок вкладки браузера берём из meta маршрута
router.afterEach((to) => {
  document.title = (to.meta.title as string) ?? 'Тестовое задание'
})

export default router
