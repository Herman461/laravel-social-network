<template>
    <div class="followers flex flex-col flex-auto items-end">
        <div class="mb-4 inline-flex items-center">
            <div class="flex flex-col items-end mr-2">
                <div class="text-lg leading-5 font-medium">{{followersCount}}</div>
                <div class="text-white text-sm leading-1">Followers</div>
            </div>
            <GroupPeople viewBox="0 0 26 26" width="30" height="30" class="text-pink-700" />
        </div>
        <button v-if="!isFollower" @click="follow" type="button" class="group base-button relative rounded-lg">
            <span class="transition inline-flex justify-center align-center h-12 pl-6 pe-8 min-w-[150px] pt-2 pb-2 text-white text-lg rounded-lg">Follow</span>
        </button>

        <button v-if="isFollower" @click="unfollow" type="button" class="transition group base-button base-button-dark relative rounded-lg">
            <span class="transition inline-flex justify-center align-center h-12 pl-6 pe-8 min-w-[150px] pt-2 pb-2 text-white text-lg rounded-lg">
                <span class="group-hover:hidden">Followed</span>
                <span class="group-hover:block hidden">Unfollow</span>
            </span>
        </button>
    </div>
</template>

<script setup>
import GroupPeople from '../../../../images/icons/group-people.svg?component';
import {computed} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/profile/types.js";

const followersCount = computed(() => store.state.profile.user.followers_count)
const isFollower = computed(() => store.state.profile.isFollower)

const follow = () => {
    store.dispatch('profile/' + types.FOLLOW)
}
const unfollow = () => {
    store.dispatch('profile/' + types.UNFOLLOW)
}
</script>

<style lang="scss" scoped>
.base-button {
    animation: pulse-button-shadow 1.5s linear infinite;
    box-shadow: 0 0 0 0 rgba(#DB2777, .5);
}
span {
    position: relative;
    z-index: 5;
}
.base-button::before {
    content: "";
    border-radius: 0.5rem;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #DB2777;
    animation: pulse-button-scale 1.5s linear infinite;
}
.base-button-dark {

    animation: none !important;
    box-shadow: none !important;

    &::before {
        @apply transition;
        animation: none;

    }

}
.base-button-dark:hover {
    &::before {
        background: #77153f;
    }
    span {
        color: #beb9b9;
    }
}
.base-button:hover {
    animation: none;
    box-shadow: 0 0 0 8px rgba(#DB2777, 0.1);
}

@keyframes pulse-button-shadow {
    0% {

    }
    70% {

        box-shadow: 0 0 0 10px rgba(#DB2777, 0);
    }
    100% {

        box-shadow: 0 0 0 0 rgba(#DB2777, 0);
    }
}
@keyframes pulse-button-scale {
    0% {
        transform: scale(.97);
    }
    70% {
        transform: scale(1);

    }
    100% {
        transform: scale(.97);

    }
}
</style>
