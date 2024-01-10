<template>
    <div @click="onAvatarClick" :class="{loading: state.isLoading}" class="group avatar pulse">
        <input @change="onAvatarChange" ref="file" type="file" accept=".jpg,.jpeg,.png" class="hidden">
        <div class="pulse-item"></div>
        <div class="avatar-wrapper overflow-hidden">
            <div v-if="imageSrc && !state.isLoading" class="w-full h-full">
                <img :src="'/storage/images/uploads/' + imageSrc" alt="" class="transition group-hover:scale-110 w-full h-full absolute left-1/2 top-1/2 -translate-y-2/4 -translate-x-2/4 object-cover object-center" />
            </div>
            <div v-if="!imageSrc && !state.isLoading" class="w-full h-full">
                <PersonIcon viewBox="0 0 24 24" class="transition group-hover:scale-110 w-32 h-32 text-pink-600 absolute left-1/2 -translate-x-2/4 -bottom-2" />
            </div>
            <div v-if="state.isLoading" class="w-fill h-full flex items-center justify-center">
                <BaseLoader class="absolute" />
            </div>
        </div>
    </div>
</template>

<script setup>
import PersonIcon from '../../../../images/icons/person.svg?component';
import {computed, reactive, ref} from "vue";
import BaseLoader from "../../common/BaseLoader.vue";
import store from "../../../../store/store.js";
import types from "../../../../store/profile/types.js";


const file = ref(null)
const state = reactive({
    isLoading: false
})

const imageSrc = computed(() => store.state.profile.user.avatar)

const onAvatarClick = () => {
    file.value.click()
}
const onAvatarChange = async (e) => {
    const image = e.target.files[0]

    state.isLoading = true

    const form = new FormData()
    form.append('avatar', image)

    const timeBeforeRequest = Date.now()
    await store.dispatch('profile/' + types.UPDATE_AVATAR, form)

    const timeAfterRequest = Date.now() - timeBeforeRequest
    const timeDiff = 1200 - timeAfterRequest

    if (timeDiff > 0) {
        setTimeout(() => {
            state.isLoading = false
        }, timeDiff)
    } else {
        state.isLoading = false
    }

    e.target.value = null
}
</script>

<style lang="scss" scoped>
.avatar {
    @apply bg-neutral-900 translate-y-2/4
    rounded-full h-36 w-36
    absolute bottom-0
    left-8
    flex items-center justify-center
    cursor-pointer border-2
    border-solid border-pink-900

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
