import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import RegisterView from '@/views/RegisterView.vue'
import LoginView from '@/views/LoginView.vue'
import { useUserStore } from '@/stores/user'
import PublicThingView from '@/views/PublicThingView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        isAuthenticated: true,
      },
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView,
      meta: {
        hideHeader: true,
        hideNavbar: true,
      },
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: {
        hideHeader: true,
        hideNavbar: true,
      },
    },
    {
      path: '/public',
      name: 'public',
      component: PublicThingView,
      meta: {
        hideBoards: true,
      },
    },
  ],
})

router.beforeEach(async (to, from) => {
  const userStore = useUserStore()

  if (to.meta.isAuthenticated && !userStore.isAccount && to.name !== 'login') {
    return { name: 'login' }
  }
})

export default router
