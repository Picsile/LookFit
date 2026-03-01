<script setup lang="ts">
import { authApi } from '@/api/api'
import InputLabel from '@/components/InputLabel.vue'
import LoaderForm from '@/components/LoaderForm.vue'
import router from '@/router'
import { useUserStore } from '@/stores/user'
import { ref, watch } from 'vue'
import { Field, Form, type SubmissionContext } from 'vee-validate'

const userStore = useUserStore()

interface LoginForm {
  email: string
  password: string
}

const loginValidation = {
  email: (value: string) => {
    if (!value) return 'Введите email'
    return true
  },

  password: (value: string) => {
    if (!value) return 'Введите пароль'
    return true
  },
}

const isLoad = ref<boolean>(false)

async function login(values: LoginForm, { setErrors }: SubmissionContext): Promise<void> {
  try {
    isLoad.value = true

    const data = await authApi.login(JSON.stringify(values))

    if (data.status === 'success') {
      // Получили данные
      userStore.setUser(data.user)
      localStorage.setItem('token', data.token)

      await router.push({ name: 'home' })
      
    } else if (data.errorsValidation) {

      const errors = data.errorsValidation

      for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
          errors[key] = errors[key][0]
        }
      }

      setErrors(data.errorsValidation)
      return
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
      <Form
        @submit="login"
        :validation-schema="loginValidation"
        v-sote="{ setErrors }"
        class="flex flex-col items-center gap-8 w-120 bg-(--color-main-panel) px-22 py-14 rounded-4xl"
      >
        <!-- Hi -->
        <div class="flex flex-col gap-2 items-center">
          <img src="../assets/logo.svg" width="52" alt="" class="pb-4" />

          <h1 class="flex flex-col items-center gap-2 text-3xl">
            <span>С возвращением в</span><span class="font-bold">LookFit!</span>
          </h1>
          <span class="text-md">Лучшие образы уже ждут тебя!</span>
        </div>

        <!-- Fields -->
        <div class="flex flex-col gap-6 w-full">
          <Field name="email" v-slot="{ field, errorMessage }">
            <InputLabel
              v-bind="field"
              v-model="field.value"
              type="text"
              :errorMessage="errorMessage"
              label="Адрес электронной почты"
              placeholder="lookfit@gmail.com"
            />
          </Field>

          <Field name="password" v-slot="{ field, errorMessage }">
            <InputLabel
              v-bind="field"
              v-model="field.value"
              type="text"
              :errorMessage="errorMessage"
              label="Пароль"
              placeholder=""
            />
          </Field>
        </div>

        <!-- Btn send -->
        <div class="w-full flex flex-col gap-3 text-center">
          <button
            type="submit"
            class="w-full text-center bg-(image:--color-brend) text-white py-3 rounded-xl hover:bg-(image:--color-hover-brend) transition-all cursor-pointer"
          >
            Войти
          </button>
          <div class="text-sm pt-2 pb-4">
            <span>Нет аккаунта? 👉 </span>

            <RouterLink :to="{ name: 'register' }" class="text-blue-500 hover:text-blue-700">
              Зарегистрироваться
            </RouterLink>
          </div>
        </div>

        <LoaderForm :isLoad="isLoad" />
      </Form>
      <!-- <div class="flex flex-col items-center gap-8 w-120 bg-(--color-main-panel) px-22 py-14 rounded-4xl">Вы успешно зарегистрировались!</div> -->
    </div>
  </div>
</template>
