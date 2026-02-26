<script setup lang="ts">
import { authApi } from '@/api/api'
import InputLabel from '@/components/InputLabel.vue'
import LoaderForm from '@/components/LoaderForm.vue'
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { onMounted, ref, watch } from 'vue'

const userStore = useUserStore()

interface RegisterForm {
  email: string
  password: string
}

const form = ref<RegisterForm>({
  email: 'q@q.com',
  password: 'q',
})

const isLoad = ref(false)

async function login() {
  try {
    isLoad.value = true

    const data = await authApi.login(JSON.stringify(form.value))

    if (data.status === 'success') {
      const token = ref(data.token)

      localStorage.setItem('token', token)
      authApi.findByToken(token)
      
      router.push({ name: 'home' })
    }
  } catch (error) {
    console.error(error)
  } finally {
    isLoad.value = false
  }
}

watch(
  () => userStore.isAccount,
  (val) => {
    if (val) router.push({ name: 'home' })
  },
)
</script>

<template>
  <div class="overflow-hidden w-screan h-screen">
    <!-- <div autoplay muted loop class="fixed -z-10 w-full object-cover object-center">
      <img src="../assets/background.jpg" alt="" class="w-full">
    </div> -->

    <div class="flex justify-center items-center w-full h-full">
      <form
        @submit.prevent="login"
        action=""
        class="flex flex-col items-center gap-8 w-120 bg-(--color-main-panel) px-22 py-14 rounded-4xl"
      >
        <div class="flex flex-col gap-2 items-center">
          <img src="../assets/logo.svg" width="52" alt="" class="pb-4" />

          <h1 class="flex flex-col items-center gap-2 text-3xl">
            <span>С возвращением в</span><span class="font-bold">LookFit!</span>
          </h1>
          <span class="text-md">Лучшие образы уже ждут тебя!</span>
        </div>

        <div class="flex flex-col gap-6 w-full">
          <InputLabel
            v-model="form.email"
            label="Адрес электронной почты"
            placeholder="lookfit@gmail.com"
            type="text"
          />

          <InputLabel v-model="form.password" label="Пароль" placeholder="" type="text" />
        </div>

        <div class="w-full flex flex-col gap-3 text-center">
          <button
            type="submit"
            class="w-full text-center bg-(image:--color-brend) text-white py-3 rounded-xl hover:bg-(image:--color-hover-brend) transition-all"
          >
            Войти
          </button>
          <div class="text-sm py-4">
            <span>Нет аккаунта? 👉 </span>

            <RouterLink :to="{ name: 'register' }" class="text-blue-500 hover:text-blue-700">
              Зарегистрироваться
            </RouterLink>
          </div>
        </div>

        <LoaderForm :isLoad="isLoad" />
      </form>
      <!-- <div class="flex flex-col items-center gap-8 w-120 bg-(--color-main-panel) px-22 py-14 rounded-4xl">Вы успешно зарегистрировались!</div> -->
    </div>
  </div>
</template>
