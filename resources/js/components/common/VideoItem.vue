<template>
    <div @mouseleave="stopVideo" class="item pl-2 pr-2 basis-1/4 mb-4">
        <div class="pb-4 bg-neutral-900"   >
            <div @mouseenter="playVideo" class="video w-full h-56 relative cursor-pointer">
                <video @timeupdate="onTimeUpdate" muted ref="video" class="w-full h-full object-cover absolute top-0 left-0 rounded-t-md" preload="metadata">
                    <source :src="'api/videos/01.mp4?id=' + Math.random()" type="video/mp4" />
                </video>
                <div class="range-slider absolute bottom-0 left-0">
                    <div class="range-slider-wrapper relative">
<!--                        <input ref="progressbar" @change="onProgressbarChange" value="0" min="0" max="14" type="range" class="absolute h-1 w-full bottom-0 left-0">-->
                        <div class="progress">
                            <div
                                @mousedown="onThumbMove"
                                class="progress-thumb"
                                :style="{left: state.progress + '%', cursor: state.isThumbGrabing ? 'grabbing' : 'grab'}"
                            >

                            </div>
                            <div class="progress-active" :style="{width: state.progress + '%'}"></div>
                        </div>
                    </div>

                </div>

                <!--            <img src="/storage/images/uploads/1704842833.jpg" class="w-full h-full object-cover absolute top-0 left-0 rounded-t-md" alt="">-->
            </div>
        </div>

        <div class="bg-neutral-900 h-12 w-full rounded-b-md">

        </div>
    </div>
</template>

<script setup>

import {reactive, ref} from "vue";
import {http} from "../../axios.js";

const state = reactive({
    progress: 0,
    isThumbGrabing: false
})
const video = ref(null)
const progressbar = ref(null)

const onThumbMove = (e) => {
    e.preventDefault()

    state.isThumbGrabing = true

    e = e || window.event;
    const thumb = e.currentTarget
    let start = 0, diff = 0;
    if( e.pageX) start = e.pageX;
    else if( e.clientX) start = e.clientX;

    const currentProgress = state.progress

    document.body.onmousemove = function(e) {
        e = e || window.event
        let end = 0

        if( e.pageX) end = e.pageX

        else if( e.clientX) end = e.clientX

        diff = end - start;

        let result

        if (diff > 0) {
            result = ( Math.abs(diff) / 300 * 100 ) + currentProgress
        } else {
            result = currentProgress - ( Math.abs(diff) / 300 * 100 )
        }

        if (result < 0) {
            state.progress = 0
            video.value.currentTime = 0
            return
        }
        if (result >= 100) {
            state.progress = 100
            video.value.currentTime = video.value.duration
            return
        }

        state.progress = result
        video.value.currentTime = Math.floor((result * video.value.duration) / 100)
        console.log(video.value.currentTime)
    };
    document.body.onmouseup = function() {
        state.isThumbGrabing = false

        // do something with the action here
        // elem has been moved by diff pixels in the X axis
        // thumb.style.position = 'static';
        document.body.onmousemove = document.body.onmouseup = null;
    };
}
const playVideo = () => {

    video.value.play()
}

const stopVideo = () => {
    video.value.pause()
    video.value.currentTime = 0
}
const onTimeUpdate = () => {
    state.progress = (video.value.currentTime * 100) / video.value.duration
    // if (!(progressbar.value.value > video.value.currentTime)) {
    //     progressbar.value.value = video.value.currentTime
    // }

}
// const onProgressbarChange = () => {
//     video.value.currentTime = String(progressbar.value.value)
//     console.log(video.currentTime)
//
// }
</script>

<style scoped lang="scss">
//input[type="range"]::-webkit-slider-runnable-track {
//    width: 100%;
//    height: 1.2em;
//    cursor: pointer;
//    border: 1px solid #29334f;
//    overflow: hidden;
//}

.video {
    padding-bottom: 144%;
}
//input[type=range] {
//    -webkit-appearance: none;
//    @apply bg-gray-700
//}
//
input[type="range"]::-webkit-slider-thumb {
    //display: none;
    //-webkit-appearance: none;
    //transition : all .3s;
    //border-radius: 50%;
    //@apply h-2 w-2 bg-pink-700
}

input[type="range"] {
    -webkit-appearance: none;
    width: 100%;
    height: 2px;
    margin: 0;
    background: transparent;
    cursor: -webkit-grab;
    cursor: grab;
    outline: none;
    z-index: 5;
}
.range-slider-wrapper {
    height: 2px;
}
.range-slider {
    width: 100%;
    height: 2px;
    border-radius: 3px;
}
.progress {
    position: absolute;
    top: 0;
    left: 0;

    width: 100%;
    height: 2px;
    background: red;

    border-radius: 2px;
    &::before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;

        top: 0;
        bottom: 0;

        height: 100%;
        width: 100%;
        z-index: 1;
        border-radius: inherit;
        @apply bg-neutral-700
    }
}
.progress-active {
    @apply bg-pink-700;
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    height: 100%;
    width: 60%;
    z-index: 3;
    pointer-events: none;
    border-radius: inherit;
    transition: all 0.3s linear 0s;
}
.progress-thumb {

    position: absolute;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 16px;
    height: 16px;
    border-radius: 50%;
    z-index: 4;
    transition: left 0.3s linear 0s;
    display: inline-flex;
    justify-content: center;
    align-items: center;


    &::before {
        content: "";
        width: 6px;
        height: 6px;
        @apply bg-pink-700;
        border-radius: 50%;
    }
}
</style>
