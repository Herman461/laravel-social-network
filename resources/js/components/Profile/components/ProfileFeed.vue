<template>
    <div data-fullscreen-wrapper class="pt-8 feed -ml-2 -mr-2">
        <VideoItem
            @set-fullscreen="setFullscreen"
            @exit-fullscreen="resetFullscreen"
            :key="video.id" v-for="(video, index) in videos"
            :index="index"
            :video="video"
        />
        <div v-if="state.isLoading" class="flex justify-center w-full">
            <BaseLoader />
        </div>

    </div>
</template>

<script setup>
import VideoItem from "../../common/VideoItem/VideoItem.vue";
import {computed, reactive} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/videos/types.js";
import BaseLoader from "../../common/BaseLoader.vue";

// document.documentElement.classList.add('default')

const state = reactive({
    perPage: 4,
    currentPage: 1,
    isLoading: false
})
const lastPage = computed(() => store.state.videos.lastPage)
const requestFullScreen = (el) => {
    // Supports most browsers and their versions.
    const requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

    if (requestMethod) { // Native full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        const wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
    return false
}

const cancelFullScreen = () => {
    const el = document;
    const requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen||el.webkitExitFullscreen;
    if (requestMethod) { // cancel full screen.
        requestMethod.call(el);
    } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
        const wscript = new ActiveXObject("WScript.Shell");
        if (wscript !== null) {
            wscript.SendKeys("{F11}");
        }
    }
}
const toggleFullscreen = () => {
    const el = document.body

    const isInFullScreen = (document.fullScreenElement && document.fullScreenElement !== null) ||  (document.mozFullScreen || document.webkitIsFullScreen);

    if (isInFullScreen) {
        cancelFullScreen();
    } else {
        requestFullScreen(el);
    }
    return false;
}
const setFullscreen = () => {
    if (document.documentElement.classList.contains('fullscreen')) return

    toggleFullscreen()
    document.documentElement.classList.add('fullscreen')
    // document.documentElement.classList.remove('default')
}
const resetFullscreen = () => {
    if (!document.documentElement.classList.contains('fullscreen')) return

    toggleFullscreen()
    document.documentElement.classList.remove('fullscreen')
}

const onFullScreenChange = () => {
    var isInFullScreen = (document.fullScreenElement && document.fullScreenElement !== null) ||  (document.mozFullScreen || document.webkitIsFullScreen);
    store.commit('videos/' + types.TOGGLE_IS_FULLSCREEN)
    if (!isInFullScreen) {
        document.documentElement.classList.remove('fullscreen')
        // document.documentElement.classList.add('default')

    }

}
document.addEventListener('fullscreenchange', onFullScreenChange, false)
document.addEventListener('webkitfullscreenchange', onFullScreenChange, false)
document.addEventListener('mozfullscreenchange', onFullScreenChange, false)

const uploadVideosOnScroll = async () => {
    console.log('scroll')
    const documentHeight = document.body.scrollHeight
    const currentScroll = window.scrollY + window.innerHeight

    if (state.isLoading) return

    const modifier = 100

    if(currentScroll + modifier > documentHeight) {
        console.log('You are at the bottom!')

        state.isLoading = true
        state.currentPage += 1

        if (state.currentPage > lastPage.value) {

            state.isLoading = false

            window.removeEventListener('scroll', uploadVideosOnScroll)
            return
        }

        await store.dispatch('videos/' + types.GET_VIDEOS, {perPage: state.perPage, page: state.currentPage})

        state.isLoading = false
    }

}

window.addEventListener('scroll', uploadVideosOnScroll)
const videos = computed(() => store.state.videos.videos)

store.dispatch('videos/' + types.GET_VIDEOS, {perPage: state.perPage, page: 1})
</script>

<style scoped lang="scss">
.feed {
    @apply flex flex-wrap
}
</style>
