<template>
    <div class="group avatar pulse">
        <div class="pulse-item"></div>
        <div class="avatar-wrapper overflow-hidden">
            <div v-if="props.imageSrc" class="w-full h-full">
                <img :src="'/storage/images/uploads/' + props.imageSrc" alt="" class="transition group-hover:scale-110 w-full h-full absolute left-1/2 top-1/2 -translate-y-2/4 -translate-x-2/4 object-cover object-center" />
            </div>
            <div v-if="!props.imageSrc" class="w-full h-full">
                <PersonIcon viewBox="0 0 24 24" class="transition group-hover:scale-110 w-20 h-20 text-pink-600 absolute left-1/2 -translate-x-2/4 -bottom-2" />
            </div>
        </div>
    </div>
</template>

<script setup>
import PersonIcon from '../../../images/icons/person.svg?component';

const props = defineProps({
    imageSrc: {
        type: String,
        default: ""
    }
})
</script>

<style lang="scss" scoped>
.avatar {
    @apply bg-neutral-900
    rounded-full h-24 w-24
    flex items-center justify-center
    cursor-pointer border-2
    border-solid border-pink-900
    relative
}
.pulse::before,
.pulse::after {
    border-radius: 50% !important;
}
.pulse-item {
    border-radius: 50% !important;
}
.avatar-wrapper {
    @apply relative w-full h-full rounded-full
}

.avatar.loading {
    .pulse-item {
        opacity: 0 !important;
        animation: none;
        transform: scale(0) !important;
    }
    &::before,
    &::after {
        opacity: 0 !important;
        transform: scale(0) !important;
        animation: none;
    }
}
.avatar::after {
    transition-delay: 1.2s;
}
.avatar-wrapper::before {
    transition-delay: 0.8s;
}

</style>
