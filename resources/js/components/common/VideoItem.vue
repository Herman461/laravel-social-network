<template>
    <div @click="onClick" @mouseleave="stopVideo" class="item pl-2 pr-2 basis-1/4 mb-4 relative">

        <div class="bg-neutral-900 pb-4 relative z-30">
            <div @mouseenter="playVideo" class="video w-full h-56 relative cursor-pointer">
                <video
                    loop muted
                    @timeupdate="onTimeUpdate"
                    ref="video"
                    class="w-full h-full object-cover absolute top-0 left-0 rounded-t-md" preload="metadata"
                >
                    <source :src="'/api/videos/stream/01.mp4?id=' + Math.random()" type="video/mp4" />
                </video>
                <div
                    class="progress"
                    :class="{'hidden': state.isProgressbarHidden}"
                >

                    <div
                        @mousedown="onThumbMove"
                        class="progress-thumb"
                        :style="{left: state.progress + '%', cursor: state.isThumbGrabing ? 'grabbing' : 'grab'}"
                    >
                        <div
                            class="relative"
                            :class="{'hidden': !state.isThumbGrabing}"
                        >
                            <div class="progress-time inline-flex bg-pink-700 py-1 px-1 text-sm rounded-md font-medium">{{state.currentTime}}</div>
                        </div>

                    </div>
                    <div class="progress-active" :style="{width: state.progress + '%'}"></div>
                </div>
            </div>
        </div>
        <div class="flex justify-between bg-neutral-900 pb-4 h-10 w-full rounded-b-md relative z-30 pl-2 pr-2">
            <div class="inline-flex items-center">
                <EyeIcon viewBox="0 0 24 24" class="text-white transition w-6 h-6" />
                <span class="group-hover:text-pink-500 font-medium transition text-md ml-1">34M</span>
            </div>
            <div class="group cursor-pointer inline-flex items-center">
                <FavoriteFillIcon viewBox="0 0 24 24" class="group-hover:text-pink-700 text-transparent stroke-pink-700 transition w-6 h-6" />
                <span class="group-hover:text-pink-500 font-medium transition text-md ml-1">2150</span>
            </div>

        </div>
        <div
            class="transition duration-500 py-3 px-2 z-20 overflow-auto absolute h-full bg-neutral-900 top-0 right-3 rounded-md comments"
            :class="{'active': state.isCommentBlockActive}"
        >
            <div class="comments-item flex mb-3">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
            <div class="comments-item flex mb-3 last:mb-0">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
            <div class="comments-item flex mb-3 last:mb-0">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
            <div class="comments-item flex mb-3 last:mb-0">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
            <div class="comments-item flex mb-3 last:mb-0">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
            <div class="comments-item flex mb-3 last:mb-0">
                <BaseAvatar :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">Тедя</div>
                    <div class="text-[12px] leading-tight">Это очень качественное видео! Получил море удовольствия от просмотра!</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {reactive, ref} from "vue";
import {http} from "../../axios.js";
import BaseAvatar from "./BaseAvatar.vue";
import FavoriteFillIcon from '../../../images/icons/favorite-fill.svg?component';
import EyeIcon from '../../../images/icons/eye.svg?component';

const state = reactive({
    progress: 0,
    isThumbGrabing: false,
    isProgressbarHidden: true,
    currentTime: '0:00',
    isCommentBlockActive: false,
})

const onClick = () => {
    state.isCommentBlockActive = !state.isCommentBlockActive

    if (state.isCommentBlockActive) {
        document.body.onclick = function(e) {
            console.log('click')
            if (!e.target.closest('.item')) {
                state.isCommentBlockActive = false
                document.body.onclick = null
            }
        }
    }
}
const video = ref(null)
const progressbar = ref(null)


const playVideo = () => {
    state.isProgressbarHidden = false
    video.value.play()
}

const stopVideo = () => {
    state.isProgressbarHidden = true
    video.value.pause()
    video.value.currentTime = 0
}
const onTimeUpdate = () => {
    state.progress = (video.value.currentTime * 100) / video.value.duration


    const minutes = Math.floor(video.value.currentTime / 60);
    let seconds = Math.floor(video.value.currentTime % 60);

    if (seconds <= 9) {
        seconds = '0' + seconds
    }

    if (video.value.currentTime < 60) {
        state.currentTime = minutes + ':' + seconds
    }
}

const onThumbMove = (e) => {
    e.preventDefault()

    state.isThumbGrabing = true

    e = e || window.event
    const thumb = e.currentTarget
    let start = 0, diff = 0;
    if( e.pageX) start = e.pageX
    else if( e.clientX) start = e.clientX

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
    };
    document.body.onmouseup = function() {
        state.isThumbGrabing = false

        document.body.onmousemove = document.body.onmouseup = null
    };
}

</script>
<style lang="scss">
.item .comments .ps {
    height: 100%;
}
</style>
<style scoped lang="scss">
.comments {
    width: calc(100% - 20px);
    //@apply -translate-x-full;
    &.active {
        //width: 100%;
        @apply translate-x-full right-0;
    }
}
.progress-time {
    position: absolute;
    top: -0.6rem;
    left: 0;
    transform: translate(-60%, -100%);
    &::before {
        content: '';
        @apply h-2 w-2 bg-pink-700 text-sm -rotate-45 transform origin-top-left absolute bottom-0 left-1/2 -translate-x-[0.32rem] translate-y-2;
    }

}
.video {
    padding-bottom: 144%;
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
    bottom: 0;
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
