<template>
    <component
        :disabled="props.disabled"
        :is="props.component"
        class="base-button"
        :class="{disabled: props.disabled}"
    >
        {{ props.text }}
    </component>
</template>

<script setup>
const props = defineProps({
    text: {
        type: String,
        default: 'Submit'
    },
    component: {
        type: String,
        default: 'button'
    },
    disabled: {
        type: Boolean,
        default: false
    }
})
</script>
<style scoped lang="scss">

.base-button {
    @apply h-16 text-2xl
    bg-pink-700 w-full
    flex items-center justify-center
    transition-all hover:bg-rose-800 duration-[400ms];
    &.disabled {
        @apply cursor-default bg-pink-900 text-white/60;
    }
}

</style>
