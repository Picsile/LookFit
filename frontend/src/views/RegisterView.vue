<script setup lang="ts">
import InputLabel from '@/components/InputLabel.vue'
import LoaderForm from '@/components/LoaderForm.vue'
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { ref, watch } from 'vue'
import { RouterLink } from 'vue-router'

const userStore = useUserStore()

interface RegisterForm {
  login: string
  username: string
  email: string
  password: string
}

const form = ref<RegisterForm>({
  login: '',
  username: '',
  email: '',
  password: '',
})

const isLoad = ref(false)

async function register() {
  try {
    isLoad.value = true

    const response = await fetch('https://lookfit.local/backend/site/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(form.value),
    })

    isLoad.value = false

    const result = await response.json()

    if (result.status === 'success') {
      localStorage.setItem('token', result.token)
      userStore.checkToken()
      router.push({ name: 'home' })
    } else {
      console.error(result)
    }
  } catch (error) {
    console.error(error)
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
        @submit.prevent="register"
        class="relative flex flex-col items-center gap-8 w-122 bg-(--color-main-panel) px-22 py-14 rounded-4xl"
      >
        <div class="flex flex-col gap-2 items-center">
          <img src="../assets/logo.svg" width="52" alt="" class="pb-4" />

          <h1 class="flex flex-col items-center gap-2 text-3xl">
            <span>Добро пожаловать в</span><span class="font-bold">LookFit!</span>
          </h1>
          <span class="text-md">Лучшие образы уже ждут тебя!</span>
        </div>

        <div class="flex flex-col gap-6 w-full">
          <InputLabel v-model="form.login" label="Логин" placeholder="outfit" type="text" />

          <InputLabel v-model="form.username" label="Имя" placeholder="Олег" type="text" />

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
            Зарегистрироваться
          </button>
          <div class="text-sm py-4">
            <span>Уже есть аккаунт? 👉 </span>

            <RouterLink :to="{ name: 'login' }" class="text-blue-500 hover:text-blue-700"> Войти </RouterLink>
          </div>
        </div>

        <LoaderForm :isLoad="isLoad" />
      </form>
    </div>
  </div>
</template>
