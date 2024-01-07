<template>
    <button class="base-button">{{props.text}}</button>
</template>

<script setup>
const props = defineProps({
  text: {
      type: String,
      default: 'Submit'
  }
})
</script>
<style scoped lang="scss">
.base-button {
    @apply h-16 text-2xl
    bg-pink-700 w-full
    flex items-center justify-center
    transition hover:bg-rose-800 duration-[400ms]
}

</style>
