<template>
    <BaseVideoFeed category="profile" :videos="videos" />
</template>

<script setup>

import {computed, reactive} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/videos/types.js";

import BaseVideoFeed from "../../common/BaseVideoFeed.vue";

const state = reactive({
    perPage: 4,
    currentPage: 1,
    isLoading: false
})

const lastPage = computed(() => store.state.videos.lastPage)


const uploadVideosOnScroll = async () => {
    const documentHeight = document.body.scrollHeight
    const currentScroll = window.scrollY + window.innerHeight

    if (state.isLoading) return

    const modifier = 100

    if(currentScroll + modifier > documentHeight) {

        state.isLoading = true
        state.currentPage += 1

        if (state.currentPage > lastPage.value) {

            state.isLoading = false

            window.removeEventListener('scroll', uploadVideosOnScroll)
            return
        }

        await store.dispatch('videos/' + types.GET_VIDEOS, {perPage: state.perPage, page: state.currentPage, category: "profile"})

        state.isLoading = false
    }

}

window.addEventListener('scroll', uploadVideosOnScroll)
const videos = computed(() => store.state.videos.videos.profile)

store.dispatch('videos/' + types.GET_VIDEOS, {perPage: state.perPage, page: 1, category: 'profile'})
</script>

<style scoped lang="scss">
.feed {
    @apply flex flex-wrap
}
</style>
