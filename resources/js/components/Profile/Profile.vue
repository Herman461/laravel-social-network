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
                <div class="info pt-6">
                    <div class="pl-48 text-white text-lg">{{login}}</div>

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
body {
    @apply text-white;
}
*::selection {
    @apply text-white bg-violet;
}
.icon svg {
    width: 28px;
    height: 28px;
    fill: #fff !important;
}
</style>
