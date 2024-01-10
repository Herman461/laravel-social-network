<template>
    <div class="bg-black min-h-full min-h-screen">
        <base-header />

        <main class="md:container flex mx-auto pt-5">
            <base-sidebar />
            <div class="flex-auto ps-8" v-if="!isLoading">
                <div class="relative">
                    <ProfileBanner />
                    <ProfileAvatar />
                </div>
                <div class="info pt-6 flex">
                    <div class="pl-48 text-white text-lg">{{login}}</div>
                    <ProfileFollowers />
                </div>
                <div v-for="post in posts" class="post mb-8 last:mb-0 bg-gray-950 p-3 rounded-lg">
                    <div class="flex">
                        <div class="mr-2 w-14 h-14 inline-flex items-end overflow-hidden justify-center bg-white rounded-full border-2 border-violet">
                            <img class="w-12 h-12" src="/storage/images/default/avatar-default.png" alt="">
                        </div>
                        <div class="self-center">
                            <div class="text-white text-sm font-medium">{{post.user.name}}</div>
                            <div class="text-white text-xs font-medium">{{createDate(post.user.created_at)}}</div>
                        </div>
                    </div>
                    <div class="text-base font-normal my-3">
                        <p>
                            {{post.post.text}}
                        </p>
                    </div>
                    <div class="actions h-10 flex items-center border-t border-violet">
                        <div @click="toggleLike" class="actions-item cursor-pointer inline-flex items-center">
                            <div class="icon mr-1">
                                <FavoriteIcon viewBox="0 0 24 24" />
                            </div>
                            <span class="text-sm font-medium">23</span>
                        </div>


                    </div>
                    <div v-if="post.comments.length > 0" class="comments p-3">
                        <div v-for="comment in post.comments" class="comment mb-3 last:mb-0">
                            <div class="flex">
                                <div class="mr-2 w-10 h-10 inline-flex items-end overflow-hidden justify-center bg-white rounded-full border-2 border-violet">
                                    <img v-if="comment.user.avatar" class="w-10 h-10" :src="'/storage/images/uploads/' + comment.user.avatar" alt="">
                                    <img v-else class="w-8 h-8" src="/storage/images/default/avatar-default.png" alt="">
                                </div>
                                <div class="pt-2.5">
                                    <div class="text-white text-sm font-medium mb-1">{{comment.user.name}}</div>
                                    <p>
                                        {{comment.comment.content}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</template>

<script setup>

import BaseHeader from "../Header/Header.vue";
import {computed} from "vue";
import types from "../../../store/posts/types.js";
import profileTypes from "../../../store/profile/types.js";
import FavoriteIcon from '../Pages/icons/favorite.svg?component';



import { useRoute } from 'vue-router'

import BaseSidebar from "../common/BaseSidebar.vue";
import ProfileAvatar from "./components/ProfileAvatar.vue";
import ProfileBanner from "./components/ProfileBanner.vue";
import store from "../../../store/store.js";
import ProfileFollowers from "./components/ProfileFollowers.vue";



const posts = computed(() => store.state.posts.posts)
const isLoading = computed(() => store.state.profile.isLoading)
const login = computed(() => store.state.profile.user.name)

const route = useRoute()
const slug = route.params.slug


if (!store.state.profile.user.name) {
    store.dispatch('profile/' + profileTypes.UPLOAD_USER, {slug})

}




//
// store.dispatch('posts/' + types.GET_POSTS, {slug: route.params.slug ?? '', page: 1})
//
// const createDate = (date) => {
//     const fullDate = new Date(date)
//
//     return fullDate.getDate() + ' Oct. ' + fullDate.getFullYear()
// }
</script>

<style lang="scss">
.pulse-item {
    pointer-events: none;
    position: absolute;
    border: 2px solid #DB2777;
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
    border: 2px solid #DB2777;
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

