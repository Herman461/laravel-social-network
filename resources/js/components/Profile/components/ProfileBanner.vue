<template>
    <div @click="onBannerClick" class="w-full h-52 rounded-md group overflow-hidden">
        <input @change="onBannerChange" ref="file" type="file" accept=".jpg,.jpeg,.png" class="hidden">
        <div v-if="!bannerSrc || state.isLoading" class="transition flex items-center justify-center h-full w-full bg-black hover:bg-neutral-900 rounded-md border-dashed cursor-pointer border-2 border-pink-600">
            <PlusIcon v-if="!state.isLoading" class="transition group-hover:scale-110 text-pink-600 absolute top-1/2 left-1/2 -translate-y-2/4 -translate-x-2/4 w-20 h-20 group-hover:w-24 group-hover:h-24" viewBox="0 0 24 24"/>
            <BaseLoader v-if="state.isLoading" />
        </div>
        <div v-if="bannerSrc && !state.isLoading" class="w-full h-full relative cursor-pointer">
            <img :src="'/storage/images/uploads/' + bannerSrc" alt="" class="transition duration-500 group-hover:scale-110 w-full h-full absolute left-1/2 top-1/2 -translate-y-2/4 -translate-x-2/4 object-cover object-center" />
        </div>
    </div>
</template>

<script setup>
import PlusIcon from '../../../../images/icons/plus.svg?component';
import {computed, reactive, ref} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/profile/types.js";
import BaseLoader from "../../common/BaseLoader.vue";

const file = ref(null)
const state = reactive({
    isLoading: false
})
const bannerSrc = computed(() => store.state.profile.user.banner)

const onBannerClick = () => {
    file.value.click()
}

const onBannerChange = async (e) => {
    const image = e.target.files[0]

    state.isLoading = true

    const form = new FormData()
    form.append('banner', image)

    const timeBeforeRequest = Date.now()
    await store.dispatch('profile/' + types.UPDATE_BANNER, form)

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

<style scoped lang="scss">

</style>
