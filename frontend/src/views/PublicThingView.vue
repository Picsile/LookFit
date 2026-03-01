<script setup lang="ts">
import { userApi } from '@/api/api'
import ArrowBack from '@/components/ArrowBack.vue'
import IconAddImage from '@/components/icons/IconAddImage.vue'
import IconAddSimple from '@/components/icons/IconAddSimple.vue'
import IconClose from '@/components/icons/iconClose.vue'
import Input from '@/components/Input.vue'
import Textarea from '@/components/Textarea.vue'
import { Field, Form, type SubmissionContext } from 'vee-validate'
import { ref } from 'vue'

interface PostData {
  title: string
  description: string
  tags: string
}

// Images
const images = ref<File[]>([])
const previews = ref<string[]>([])
const mainPreview = ref<number>(0)

const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (!target.files) return

  images.value = [...images.value, ...Array.from(target.files)]

  previews.value = []

  images.value.forEach((file) => {
    const reader = new FileReader()

    reader.onload = (event) => {
      previews.value.push(event.target?.result as string)
    }

    reader.readAsDataURL(file)
  })
}

const removeImage = (index: number) => {
  images.value.splice(index, 1)
  previews.value.splice(index, 1)

  if (mainPreview.value > previews.value.length - 1) {
    mainPreview.value = Math.max(previews.value.length - 1, 0)
  }
}

// Links
const links = ref<string[]>([''])

const addLink = () => {
  links.value.push('')
}

const removeLink = (index: number) => {
  links.value.splice(index, 1)
}

// Save
const isLoad = ref(false)

const publicThing = async (values: PostData, { setErrors }: SubmissionContext): Promise<void> => {
  const formData = new FormData()

  // Add form values
  formData.append('title', values.title)
  formData.append('description', values.description)
  formData.append('tags', values.tags)

  // Add links
  links.value.forEach((link, i) => {
    formData.append(`links[${i}]`, link)
  })

  // Add images
  images.value.forEach((file) => {
    formData.append('images[]', file)
  })

  try {
    isLoad.value = true

    const data = await userApi.publicThing(formData)
    console.log(data)

    if (data.status == 'success') {
      console.log('Успех')
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
</script>

<template>
  <div class="flex justify-center w-screen pl-[var(--w-navbar)] pt-38.5">
    <div class="flex flex-col gap-8">
      <!-- Top -->
      <div class="flex gap-8 items-center">
        <ArrowBack path="/" />
        <div>
          <h3 class="text-40 text-xl">Публикация вещи</h3>
        </div>
      </div>

      <!-- Body -->
      <div class="flex gap-8">
        <!-- Files -->
        <div>
          <!-- File download -->
          <div v-if="!previews.length">
            <label
              for="image"
              class="input-add-image flex flex-col gap-5 justify-center items-center w-130 aspect-[1/1] bg-(--color-input) hover:bg-(--color-hover-input) rounded-2xl cursor-pointer"
            >
              <IconAddImage class="icon-add-image -mb-3 transition" width="58" />
              <span class="text-base">Выберите файл или перетащите его сюда</span>
              <span class="text-base p-1.5 px-4 border rounded-lg">Указать файл</span>
            </label>

            <input id="image" type="file" multiple @change="handleFileUpload" class="hidden" />
          </div>

          <!-- File render -->
          <div v-if="previews.length" class="w-130">
            <div class="overflow-hidden relative w-130 aspect-[1/1] bg-(--color-input) rounded-2xl">
              <img
                :key="previews[mainPreview]"
                :src="previews[mainPreview]"
                class="w-full h-full object-contain"
                alt=""
              />
              <button
                @click.stop="() => removeImage(index)"
                class="btn-image-remove absolute top-1 right-1 flex justify-center items-center w-8 h-8 p-0.5 bg-(--color-main-panel) rounded-full opacity-25 cursor-pointer hover:bg-red-300 hover:opacity-90"
              >
                <IconClose />
              </button>
            </div>
            <div class="overflow-x-scroll no-scrollbar flex gap-2 w-full mt-2">
              <!-- Image -->
              <div
                v-for="(preview, index) in previews"
                :key="index"
                @click="() => (mainPreview = index)"
                class="preview overflow-hidden relative flex justify-center items-center min-w-20 w-20 aspect-[1/1] bg-(--color-hover-input) rounded-2xl cursor-pointer"
              >
                <img class="object-fit" :src="preview" alt="" />
                <button
                  @click.stop="() => removeImage(index)"
                  class="btn-image-remove absolute top-1 right-1 flex justify-center items-center w-6 h-6 p-0.5 bg-(--color-main-panel) rounded-full opacity-25 cursor-pointer hover:bg-red-300 hover:opacity-90"
                >
                  <IconClose />
                </button>
              </div>

              <!-- Add other image -->
              <div>
                <label
                  for="image"
                  class="input-add-image flex flex-col gap-5 justify-center items-center w-20 aspect-[1/1] bg-(--color-input) hover:bg-(--color-hover-input) rounded-2xl cursor-pointer"
                >
                  <IconAddImage class="icon-add-image -mb-1 transition" width="40" />
                </label>

                <input id="image" type="file" multiple @change="handleFileUpload" class="hidden" />
              </div>
            </div>
          </div>
        </div>

        <!-- Fields -->
        <Form @submit="publicThing" v-slot="{ setErrors }" class="flex flex-col gap-4 w-120 -mt-1">
          <Field name="title" v-slot="{ field, errorMessage }">
            <Input v-bind="field" v-model="field.value" type="text" :errorMessage="errorMessage" label="Название" />
          </Field>

          <Field name="description" v-slot="{ field, errorMessage }">
            <Textarea v-bind="field" v-model="field.value" type="text" :errorMessage="errorMessage" label="Описание" />
          </Field>

          <Field name="tags" v-slot="{ field, errorMessage }">
            <Input v-bind="field" v-model="field.value" type="text" :errorMessage="errorMessage" label="Теги" />
          </Field>

          <!-- Links -->
          <div class="group flex flex-col">
            <label class="label text-base mb-0.5 group-focus-within:text-indigo-500">Ссылки</label>

            <div v-for="(link, index) in links" :key="index" class="flex gap-2 mb-4">
              <input
                type="text"
                placeholder="https://"
                class="w-full bg-(--color-input) px-5 py-2.5 rounded-2xl hover:bg-(--color-hover-input) peer focus:outline focus:outline-indigo-500"
              />
              <button
                v-if="index !== 0"
                type="button"
                @click="removeLink(index)"
                class="bg-(--color-input) p-2.5 rounded-2xl hover:bg-(--color-hover-input) focus:outline focus:outline-indigo-500 cursor-pointer"
              >
                <IconClose />
              </button>
            </div>
          </div>

          <!-- Add links -->
          <button
            type="button"
            @click="addLink"
            class="flex justify-center gap-1 w-full bg-(--color-input) py-2.5 rounded-2xl -mt-4 hover:bg-(--color-hover-input) focus:outline focus:outline-indigo-500 cursor-pointer"
          >
            <IconAddSimple width="21px" />
            <span>Добавить ссылку</span>
          </button>

          <!-- Btn send -->
          <button
            type="submit"
            class="w-full text-center bg-(image:--color-brend) text-white py-2.5 rounded-2xl mt-3 hover:bg-(image:--color-hover-brend) transition-all cursor-pointer"
          >
            Опубликовать
          </button>
        </Form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.input-add-image:hover .icon-add-image {
  scale: 1.05;
  transform: translateY(-2px);
}

.btn-image-remove:hover svg {
  stroke: white;
}

.preview:hover img {
  opacity: 0.6;
}
</style>
