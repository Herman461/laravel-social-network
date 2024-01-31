<template>
    <div data-fullscreen-wrapper class="feed -ml-2 -mr-2">
        <VideoItem
            @set-fullscreen="setFullscreen"
            @exit-fullscreen="resetFullscreen"
            :key="video.id" v-for="(video, index) in props.videos"
            :index="index"
            :video="video"
            :style="flexBasisProperty"
            :category="props.category"
        />
        <div v-if="state.isLoading" class="flex justify-center w-full">
            <BaseLoader />
        </div>

    </div>
</template>

<script setup>

import {computed, reactive} from "vue";
import store from "../../../store/store.js";
import types from "../../../store/videos/types.js";
import BaseLoader from "./BaseLoader.vue";
import VideoItem from "./VideoItem/VideoItem.vue";


const flexBasisProperty = computed(() => {
    if (props.cols === 5) {
        return 'flex: 0 1 20%'
    } else {
        return 'flex: 0 1 25%'
    }
})
// document.documentElement.classList.add('default')

const props = defineProps({
    videos: {
        type: Array,
        default: []
    },
    cols: {
        type: Number,
        default: 4
    },
    category: {
        type: String,
        required: true
    }
})
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

</script>

<style scoped lang="scss">
.feed {
    @apply flex flex-wrap
}
</style>
