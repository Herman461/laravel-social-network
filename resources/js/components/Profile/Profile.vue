<template>

<BaseWrapper>
    <template v-if="!isLoading">
        <div :class="{'profile-top': !bannerSrc}" class="relative">
            <ProfileBanner />
            <ProfileAvatar />
            <div v-if="!bannerSrc" class="info pt-6 flex pb-8 flex justify-between flex-auto">
                <div class="pl-4 self-end">
                    <div class="text-white text-2xl mb-2">{{login}}</div>
                    <div class="text-lg">Hello! I'm Kitty and I love cats. I'm sure you like my awesome videos 🔥</div>
                </div>
                <div class="flex flex-col">
                    <ProfileFollowers class="flex-auto"/>
                    <div class="flex justify-between">
                        <div class="inline-flex flex-col mr-4 last:mr-0">
                            Views
                            <div class="inline-flex">
                                <span class="text-xl font-medium text-white mr-1">{{totalViews}}</span>
                                <EyeIcon class="text-pink-700 self-end" width="30" height="30" viewBox="0 0 24 24" />
                            </div>
                        </div>
                        <div class="inline-flex flex-col mr-4 last:mr-0">
                            Likes
                            <div class="inline-flex">
                                <span class="text-xl font-medium text-white mr-1">52</span>
                                <FavoriteIcon class="text-pink-700 self-end" width="30" height="30" viewBox="0 0 24 24" />
                            </div>

                        </div>
                    </div>


                </div>

            </div>
        </div>
        <div v-if="bannerSrc" class="info pt-6 flex pb-8 border-solid border-b-2 border-pink-700">
            <div class="pl-48 text-white text-lg">{{login}}</div>
            <ProfileFollowers />
        </div>
        <ProfileFeed />
    </template>
</BaseWrapper>
</template>

<script setup>



import {computed} from "vue";

import types from "../../../store/profile/types.js";

import FavoriteIcon from '../../../images/icons/favorite-fill.svg?component';
import EyeIcon from '../../../images/icons/eye.svg?component';



import { useRoute } from 'vue-router'

import BaseSidebar from "../common/BaseSidebar.vue";
import ProfileAvatar from "./components/ProfileAvatar.vue";
import ProfileBanner from "./components/ProfileBanner.vue";
import store from "../../../store/store.js";
import ProfileFollowers from "./components/ProfileFollowers.vue";
import ProfileFeed from "./components/ProfileFeed.vue";
import BaseNotification from "../common/BaseNotification.vue";
import BaseWrapper from "../common/BaseWrapper.vue";



const isLoading = computed(() => store.state.profile.isLoading)
const login = computed(() => store.state.profile.user.name)
const bannerSrc = computed(() => store.state.profile.user.banner)
const totalViews = computed(() => store.state.profile.totalViews)

const route = useRoute()
const slug = route.params.slug


if (!store.state.profile.user.name) {
    store.dispatch('profile/' + types.UPLOAD_USER, {slug})

}
</script>

<style lang="scss">
.pulse-item {
    pointer-events: none;
    position: absolute;
    border: 2px solid #FF007A;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;

    animation: pulse 1s linear infinite;
    transition: all 0.3s ease 0s;
}
.pulse-item {

}
.pulse::before,
.pulse::after {
    content: '';
    position: absolute;
    border: 2px solid #FF007A;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0;
    pointer-events: none;

    transition: all 0.3s ease 0s;
}
.pulse::before {
    animation: pulse2 1.2s linear infinite;
}
.pulse::after {
    animation: pulse3 1.4s linear infinite;
}


@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.14);
        opacity: 0;
    }
}

@keyframes pulse2 {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.18);
        opacity: 0;
    }
}
@keyframes pulse3 {
    0% {
        transform: scale(1);
        opacity: 0;
    }
    50% {
        opacity: 1;
    }
    100% {
        transform: scale(1.22);
        opacity: 0;
    }
}
body {
    @apply text-white;
}
*::selection {
    @apply text-white bg-pink-700;
}
.icon svg {
    width: 28px;
    height: 28px;
    fill: #fff !important;
}
</style>

<style lang="scss" scoped>
.profile-top {
    @apply flex border-solid border-b-2 border-pink-700 pb-8;
}
</style>

