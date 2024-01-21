<template>
    <div class="pt-8 feed -ml-2 -mr-2">
        <VideoItem :key="video.id" v-for="(video, index) in videos" :index="index" :video="video" />



    </div>
</template>

<script setup>
import VideoItem from "../../common/VideoItem.vue";
import {computed} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/profile/types.js";

const videos = computed(() => store.state.profile.videos)

store.dispatch('profile/' + types.GET_VIDEOS, {perPage: 12, page: 1})
</script>

<style scoped lang="scss">
.feed {
    @apply flex flex-wrap
}
</style>
