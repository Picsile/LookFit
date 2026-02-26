<script setup lang="ts">
import { onMounted, onUnmounted, ref, useTemplateRef } from 'vue'
import { onClickOutside } from '@vueuse/core'

import IconSearch from '../components/icons/IconSearch.vue'
import IconSearchCorner from '../components/icons/IconSearchCorner.vue'
import IconUser from './icons/IconUser.vue'
import { useUserStore } from '@/stores/user'
import IconAdd from './icons/IconAdd.vue'
import IconPhoto from './icons/IconPhoto.vue'
import router from '@/router'

const userStore = useUserStore()

// Изменения при скролинге
const scrolled = ref(false)
let lastScrollY = 0

const handleScroll = () => {
  const currentScroll = window.scrollY

  if (currentScroll > lastScrollY + 20) {
    scrolled.value = true
    lastScrollY = currentScroll
  }

  if (currentScroll < lastScrollY) {
    scrolled.value = false
    lastScrollY = currentScroll
  }
}

// User modal
const isOpenUserModal = ref(false)
const userModalRef = useTemplateRef('target')
const profileRef = useTemplateRef<HTMLElement>('profile')

const toggleModal = () => {
  isOpenUserModal.value = !isOpenUserModal.value
}

onClickOutside(
  userModalRef,
  () => {
    isOpenUserModal.value = false
  },
  { ignore: [profileRef] },
)

const logout = async () => {
  userStore.logout()
  await router.push({ name: 'home' })
}

onMounted(() => {
  addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  addEventListener('scroll', handleScroll)
})
</script>

<template>
  <div class="fixed z-10 top-0 left-(--w-navbar) right-0 bg-(--color-main-panel) rounded-b-xl">
    <!-- Видимая облась -->
    <div class="relative flex flex-col w-full rounded-xl">
      <!-- Search and avatar -->
      <div
        class="absolute z-30 flex justify-between items-center gap-2 w-full bg-(--color-main-panel) py-4 px-4 rounded-xl"
      >
        <!-- Search -->
        <div class="relative w-full">
          <div class="absolute top-1/2 + -translate-y-1/2 left-4 flex items-center gap-1.5 cursor-text">
            <IconSearch width="22" height="22" />
            Поиск
          </div>
          <div
            v-if="userStore.isAccount"
            class="absolute top-1/2 + -translate-y-1/2 right-2 flex items-center cursor-pointer"
          >
            <div class="w-1 h-7 border-l border-indigo-400 pl-1.5"></div>

            <div class="p-2 rounded-xl hover:bg-(--color-hover-input)">
              <IconSearchCorner />
            </div>
          </div>

          <input
            type="text"
            name="search"
            class="flex flex-1 w-full h-[3rem] bg-(--color-input) px-4 rounded-xl hover:bg-(--color-hover-input) focus:bg-white focus:outline-indigo-400"
          />
        </div>

        <div class="flex">
          <!-- Профиль -->
          <div v-if="userStore.isAccount" class="relative">
            <div class="btn-default" @click.stop="toggleModal" ref="profile">
              <div class="w-8 h-8 overflow-hidden rounded-full">
                <img class="object-cover w-full h-full select-none" src="../../public/Avatar.jpg" alt="Avatar" />
              </div>
            </div>

            <!-- User modal -->
            <div
              v-if="isOpenUserModal"
              ref="target"
              class="user-modal absolute top-12 right-0 bg-(--color-main-panel) p-4 rounded-2xl"
            >
              <!-- Профиль -->
              <div class="btn-fit flex gap-3">
                <div class="avatar flex justify-center items-center w-12 h-12 bg-(--color-input) rounded-full">
                  <img v-if="userStore.user?.avatar_path" src="" alt="" />

                  <IconPhoto
                    v-if="!userStore.user?.avatar_path"
                    width="24"
                    height="24"
                    class="stroke-(--color-text-second)"
                  />
                </div>
                <div>
                  <h5>{{ userStore.user?.username }}</h5>
                  <span>{{ userStore.user?.email }}</span>
                </div>
              </div>
              <div class="pt-4 pb-2">
                <span class="text-[0.9rem] text-(--color-text-second)">Действия</span>
              </div>
              <button @click="logout()" class="btn-list justify-content-start w-full font-medium px-4">Выход</button>
            </div>
          </div>

          <!-- Add -->
          <div v-if="userStore.isAccount" class="btn-default">
            <IconAdd width="26" height="26" />
          </div>
        </div>

        <!-- Авторизация -->
        <router-link
          to="/login"
          v-if="!userStore.isAccount"
          class="btn-accent flex items-center gap-1.5 text-white p-2 px-4 rounded-xl cursor-pointer"
        >
          <IconUser width="20" height="20" />
          Войдите
        </router-link>
      </div>

      <!-- Boards -->
      <div
        :class="{
          'boards z-20 flex gap-5 bg-(--color-main-panel) pt-20 pb-5 px-7 rounded-xl shadow': !scrolled,
          'boards z-20 flex gap-5 bg-(--color-main-panel) pt-6 pb-5 px-7 rounded-xl shadow-xl': scrolled,
        }"
      >
        <span class="border-b-2 p-0.5 px-1.5 font-semibold cursor-pointer">Топ</span>
        <div class="p-0.5 px-1.5 font-semibold cursor-pointer">Для вас</div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.boards {
  transition: 0.3s ease-in-out;
}

.user-modal {
  box-shadow: 0px 0px 15px -7px #000000;
}

.avatar:hover {
  background-color: var(--color-hover-input);
}
</style>
