<template>
    <div data-fullscreen-item :class="{last: state.toLeftSide}" @mouseleave="stopVideo" class="item pl-2 pr-2 mb-4 relative">

        <div class="video-item bg-neutral-900 pb-2 relative rounded-t-md">
            <div class="backdrop">
                <img src="/storage/images/videos/1.jpg" alt="">
            </div>
            <div @mouseenter="playVideo" class="video w-full relative z-50 cursor-pointer">
                <video
                    loop :muted="!allowSound"
                    @ended="resetVideo"
                    @timeupdate="onTimeUpdate"
                    @play="onVideoPlay"
                    ref="video"
                    class="w-full h-full object-cover absolute top-0 left-0 rounded-t-md" preload="metadata"
                >
                    <source :src="'/api/videos/stream/' + props.video.video.name" type="video/mp4" />
                </video>
                <div
                    class="progress"
                    :style="{'width': state.progressWidth + 'px'}"
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
        <div :style="leftStyleValue" class="video-actions relative bg-neutral-900 pb-2 w-full rounded-b-md pl-2 pr-2">
            <div class="actions-top border-b w-full flex justify-between border-pink-700 pb-2">
                <div class="inline-flex items-center actions-icon">
                    <EyeIcon viewBox="0 0 24 24" class="text-white transition-all w-6 h-6" />
                    <span class="group-hover:text-pink-600 font-medium transition-all text-md ml-1 select-none">{{props.video.video.views}}</span>
                </div>
                <div class="group cursor-pointer inline-flex items-center actions-icon">
                    <FavoriteFillIcon viewBox="0 0 24 24" class="group-hover:text-pink-700 text-transparent stroke-pink-700 transition-all w-6 h-6" />
                    <span class="group-hover:text-pink-700 font-medium transition-all text-md ml-1 select-none">{{props.video.likes_count}}</span>
                </div>
            </div>
            <div class="actions-bottom flex justify-between pt-2">
                <div class="actions-bottom-item flex items-center">
                    <div class="cursor-pointer group w-7 h-7 mr-3 actions-icon actions-fullscreen-icon">
                        <FullscreenExitIcon @click="$emit('exit-fullscreen')" v-if="isFullscreen" viewBox="0 0 24 24" class="w-7 h-7 text-pink-700 transition-all group-hover:text-pink-600" />
                        <FullscreenIcon @click="$emit('set-fullscreen')" v-else viewBox="0 0 24 24" class="w-7 h-7 text-pink-700 transition-all group-hover:text-pink-600" />
                    </div>

                <VideoItemSpeed @change-video-speed="changeVideoSpeed" />

                </div>
                <div class="actions-bottom-item flex items-center">
                    <div @click="toggleSound" class="group cursor-pointer mr-3 actions-icon">
                        <SoundOnIcon v-if="allowSound" class="text-pink-700 transition-all group-hover:text-pink-600"/>
                        <SoundOffIcon v-else class="text-pink-700 transition-all group-hover:text-pink-600"/>
                    </div>
                    <div @click="toggleComments" class="comments-icon inline-flex items-center group cursor-pointer actions-icon select-none">
                        <CommentsIcon viewBox="0 0 27 24" class="text-pink-700 group-hover:text-pink-600"/>
                        <span class="group-hover:text-pink-700 font-medium transition-all text-md ml-1 select-none">{{props.video.comments_count}}</span>
                    </div>
                </div>

            </div>

        </div>
        <VideoItemComments :is-comment-block-active="state.isCommentBlockActive" :comments="props.video.comments" />
    </div>
</template>

<script setup>

import {computed, reactive, ref} from "vue";
import FavoriteFillIcon from '../../../../images/icons/favorite-fill.svg?component';
import CommentsIcon from '../../../../images/icons/comments.svg?component';
import SoundOffIcon from '../../../../images/icons/muted.svg?component';
import SoundOnIcon from '../../../../images/icons/sound.svg?component';
import FullscreenIcon from '../../../../images/icons/fullscreen.svg?component';
import FullscreenExitIcon from '../../../../images/icons/fullscreen-exit.svg?component';
import EyeIcon from '../../../../images/icons/eye.svg?component';
import types from "../../../../store/videos/types.js";
import store from "../../../../store/store.js";
import VideoItemComments from "./components/VideoItemComments.vue";
import VideoItemSpeed from "./components/VideoItemSpeed.vue";

const props = defineProps({
    video: {
        type: Object,
        required: true
    },
    index: {
        type: Number,
        required: true
    },
    category: {
        type: String,
        required: true
    }
})


const allowSound = computed(() => store.state.videos.allowSound)
const isCommentsOpened = computed(() => store.state.videos.isCommentsOpened)
const videoSpeed = computed(() => store.state.videos.videoSpeed)
const isFullscreen = computed(() => store.state.videos.isFullscreen)
const leftStyleValue = computed(() => isFullscreen.value ? ({left: 'calc(50% + ' + (state.progressWidth / 2) + 'px)'}) : ({}))

const state = reactive({
    progress: 0,
    isThumbGrabing: false,
    isProgressbarHidden: true,
    currentTime: '0:00',
    isCommentBlockActive: false,
    wasWatched: false,
    toLeftSide: false,
    hasComments: false,
    progressWidth: 0,
})

const changeVideoSpeed = () => {

    switch (videoSpeed.value) {
        case 1.0:
            store.commit('videos/' + types.UPDATE_VIDEO_SPEED, {videoSpeed: 1.25})
            video.value.playbackRate = 1.25
            break;
        case 1.25:
            store.commit('videos/' + types.UPDATE_VIDEO_SPEED, {videoSpeed: 1.5})
            video.value.playbackRate = 1.5
            break;
        case 1.5:
            store.commit('videos/' + types.UPDATE_VIDEO_SPEED, {videoSpeed: 1.75})
            video.value.playbackRate = 1.75
            break;
        case 1.75:
            store.commit('videos/' + types.UPDATE_VIDEO_SPEED, {videoSpeed: 2.0})
            video.value.playbackRate = 2.0
            break;
        default:
            store.commit('videos/' + types.UPDATE_VIDEO_SPEED, {videoSpeed: 1.0})
            video.value.playbackRate = 1.0
            break;
    }
}

const resetVideo = () => {
    console.log('end')
}

const toggleSound = () => {
    store.commit('videos/' + types.TOGGLE_SOUND)
}

const toggleComments = () => {
    if (isCommentsOpened.value) return



    store.commit('videos/' + types.TOGGLE_IS_COMMENTS_OPENED)

    setTimeout(() => {
        store.commit('videos/' + types.TOGGLE_IS_COMMENTS_OPENED)

        if (state.isCommentBlockActive) {
            document.body.onclick = function(e) {

                if (!e.target.closest('.comments')) {

                    state.isCommentBlockActive = false
                    document.body.onclick = null

                    setTimeout(() => {
                        if (state.toLeftSide) {
                            state.toLeftSide = false
                        }
                    }, 500)

                }
            }
        }

    }, 500)

    state.isCommentBlockActive = !state.isCommentBlockActive

    if (!state.hasComments) {
        state.hasComments = true
        store.dispatch(
            'videos/' + types.UPLOAD_COMMENTS,
            {
                index: props.index,
                videoId: props.video.video.id,
                page: 1, perPage: 10,
                category: props.category
            })
    }
    if (props.index !== 0 && (props.index + 1) % 4 === 0) {
        if (state.toLeftSide) {
            setTimeout(() => {
                state.toLeftSide = false
            }, 500)

        } else {
            state.toLeftSide = true
        }
    }



}
const video = ref(null)



const resizeProgressbar = () => {
    state.progressWidth = video.value.offsetWidth

}
const playVideo = () => {

    state.progressWidth = video.value.offsetWidth

    state.isProgressbarHidden = false

    video.value.playbackRate = videoSpeed.value
    video.value.play()
}
const onVideoPlay = () => {
    window.onresize = null
    window.onresize = resizeProgressbar
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

    if (!state.wasWatched) {
        const percent = (video.value.currentTime * 100) / video.value.duration

        if (percent >= 10) {

            store.dispatch('videos/' + types.INCREMENET_VIEWS, {videoId: props.video.video.id})
            state.wasWatched = true
        }
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
            result = ( Math.abs(diff) / state.progressWidth * 100 ) + currentProgress
        } else {
            result = currentProgress - ( Math.abs(diff) / state.progressWidth * 100 )
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

.backdrop {
    height: 100%;
    overflow: hidden;
    position: absolute;
    width: 100%;
    z-index: 1;

    img {
        filter: blur(18px);
        height: 100%;
        object-fit: cover;
        object-position: center;
        top: 0;
        width: 100%;
        z-index: 2;
    }
    &::before {
        content: '';
        filter: blur(18px);
        background: rgba(0, 0, 0, 0.6);
        height: 100%;
        overflow: hidden;
        position: absolute;
        width: 100%;
        z-index: 3;
    }
}
</style>
<style scoped lang="scss">


.item.last {
    .comments {
        &.active {
            right: 1.28rem;
            @apply -translate-x-full
        }
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

.progress {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translate(-50%, 0);

    height: 2px;


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

.item {
    &:nth-child(4n+1) {
        .video-item {
            z-index: 90;
        }
        .video-actions {
            z-index: 90;
        }
        .comments {
            z-index: 80;
        }
    }
    &:nth-child(4n+2) {
        .video-item {
            z-index: 70;
        }
        .video-actions {
            z-index: 70;
        }
        .comments {
            z-index: 60;
        }
    }
    &:nth-child(4n+3) {
        .video-item {
            z-index: 50;
        }
        .video-actions{
            z-index: 50;
        }
        .comments {
            z-index: 40;
        }
    }
    &:nth-child(4n+4) {
        .video-item {
            z-index: 30;
            //z-index: 80;
        }
        .video-actions {
            z-index: 30;
            //z-index: 80;
        }
        .comments {
            z-index: 20;
            //z-index: 70;
        }
        &.last {
            .video-item {
                z-index: 80;
            }
            .video-actions {
                z-index: 80;
            }
            .comments {
                z-index: 70;
            }
        }
    }
}

</style>
