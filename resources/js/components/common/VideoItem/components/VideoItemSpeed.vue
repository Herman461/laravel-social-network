<template>
    <div @click="$emit('change-video-speed')" class="video-speed-item actions-icon group">
        <Speed_1_0_Icon viewBox="0 0 26 27" v-if="videoSpeed === 1.0" class="speed-icon" />
        <Speed_1_25_Icon viewBox="0 0 33 27" v-if="videoSpeed === 1.25" class="speed-icon" />
        <Speed_1_5_Icon viewBox="0 0 26 27" v-if="videoSpeed === 1.5" class="speed-icon" />
        <Speed_1_75_Icon viewBox="0 0 33 27" v-if="videoSpeed === 1.75" class="speed-icon" />
        <Speed_2_0_Icon viewBox="0 0 28 27" v-if="videoSpeed === 2.0" class="speed-icon" />
    </div>
</template>

<script setup>
import Speed_1_0_Icon from '../../../../../images/icons/speed-1-0.svg?component';
import Speed_1_25_Icon from '../../../../../images/icons/speed-1-25.svg?component';
import Speed_1_5_Icon from '../../../../../images/icons/speed-1-5.svg?component';
import Speed_1_75_Icon from '../../../../../images/icons/speed-1-75.svg?component';
import Speed_2_0_Icon from '../../../../../images/icons/speed-2-0.svg?component';
import {computed} from "vue";
import store from "../../../../../store/store.js";

const videoSpeed = computed(() => store.state.videos.videoSpeed)
</script>

<style lang="scss" scoped>
.video-speed-item {
    @apply cursor-pointer w-7 h-7;
}
.speed-icon {
    @apply text-pink-700 transition group-hover:text-pink-600;
}
</style>
