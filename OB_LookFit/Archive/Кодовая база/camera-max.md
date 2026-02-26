# InputCamera
Создан компонент `CameraCapture.vue` для живого превью и снимка кадра в `<canvas>`.
```
<script setup>
 import { ref, onBeforeUnmount } from 'vue'

 const videoRef = ref(null)
 const canvasRef = ref(null)
 const stream = ref(null)
 const shotBlob = ref(null)
 const error = ref('')
 const isSecure = typeof window !== 'undefined' ? window.isSecureContext : false

 async function openCamera() {
   if (!isSecure) {
     error.value = 'Страница должна быть открыта по HTTPS (или localhost)'
     return
   }
   error.value = ''
   try {
     stream.value = await navigator.mediaDevices.getUserMedia({
       video: { facingMode: { ideal: 'environment' } },
       audio: false,
     })
     if (videoRef.value) {
       videoRef.value.srcObject = stream.value
       await videoRef.value.play()
     }
   } catch (e) {
     error.value = 'Нужен HTTPS и разрешение на камеру'
   }
 }

 function closeCamera() {
   if (stream.value) {
     stream.value.getTracks().forEach((t) => t.stop())
     stream.value = null
   }
 }

 async function takePhoto() {
   const v = videoRef.value
   const c = canvasRef.value
   if (!v || !c || !v.videoWidth) return
   c.width = v.videoWidth
   c.height = v.videoHeight
   const ctx = c.getContext('2d')
   ctx.drawImage(v, 0, 0, c.width, c.height)
   await new Promise((res) =>
     c.toBlob(
       (b) => {
         shotBlob.value = b
         res()
       },
       'image/jpeg',
       0.92,
     ),
   )
 }

 onBeforeUnmount(() => {
   closeCamera()
 })
 </script>

 <template>
   <section>
     <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 8px">
       <button @click="openCamera" :disabled="!isSecure">Открыть камеру</button>
       <button @click="takePhoto">Сделать фото</button>
       <button @click="closeCamera">Закрыть камеру</button>
     </div>
     <p v-if="!isSecure" style="color: #d00">Открой по HTTPS (туннель или localhost)</p>
     <p v-if="error" style="color: #d00">{{ error }}</p>
     <video
       ref="videoRef"
       playsinline
       style="width: 100%; max-height: 50vh; background: #000; border-radius: 8px"
     ></video>
     <canvas ref="canvasRef" style="display:  none"></canvas>
     <div v-if="shotBlob" style="margin-top: 12px">
       <img
         :src="URL.createObjectURL(shotBlob)"
         alt="Снимок"
         style="max-width: 100%; border-radius: 8px"
       />
     </div>
   </section>
 </template>

 <style scoped></style>
```
- `window.isSecureContext` — не даём запускать камеру по HTTP на телефоне, показываем подсказку.
- `getUserMedia` — запрашиваем видеопоток с задней камеры `facingMode: environment`.
- Снимок берём через `canvas.toBlob` с качеством `0.92` и показываем превью.
- При размонтировании закрываем `MediaStream` (`track.stop()`), чтобы освободить камеру.
