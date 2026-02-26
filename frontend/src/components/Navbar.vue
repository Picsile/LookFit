<script setup lang="ts">
import IconBell from './icons/IconBell.vue'
import IconBrush from './icons/IconBrush.vue'
import IconHome from './icons/IconHome.vue'
import IconSettings from './icons/IconSettings.vue'
</script>

<template>
  <div class="fixed z-20 top-0 left-0">
    <nav
      class="flex flex-col justify-between items-center w-[var(--w-navbar)] h-screen bg-[var(--color-main-panel)] pt-4 pb-4 border-r-1 border-r-[var(--color-border)]"
    >
      <div class="flex flex-col items-center gap-7">
        <div class="flex items-center h-[var(h-header)]">
          <div class="btn-default">
            <img class="rounded-full" src="@/assets/logo.svg" width="30" height="30" alt="Главная" />
          </div>
        </div>

        <div class="btn-default">
          <IconHome width="26 " height="26" />
        </div>

        <div class="btn-default">
          <IconBrush width="26 " height="26" />
        </div>

        <div class="btn-default">
          <IconBell width="26 " height="26" />
        </div>
      </div>

      <div>
        <div class="btn-default">
          <IconSettings width="26 " height="26" />
        </div>
      </div>
    </nav>
  </div>
</template>

<style scoped>
.btn-default:hover {
  background-color: var(--color-hover);
  animation: navbar__link 1s ease-out infinite;
}

@keyframes navbar__link {
  0%,
  40% {
    transform: rotate(0deg);
  }
  45% {
    transform: rotate(-10deg);
  }
  50% {
    transform: rotate(10deg);
  }
  55% {
    transform: rotate(-10deg);
  }
  60%,
  100% {
    transform: rotate(0deg);
  }
}
</style>
