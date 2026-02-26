# InputCamera
```
<template>
  <label>
    Снять фото
    <input type="file" accept="image" capture="environment" />
  </label>
</template>
```
- `accept="image"` — просим изображения.
- `capture="environment"` — хинт на заднюю камеру (не гарантия). Работает даже без HTTPS.