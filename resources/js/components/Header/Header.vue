<template>
    <header class="h-16 flex items-center border-b border-neutral-900">
        <div class="md:container md:mx-auto">
            <div class="relative inline-flex">
                <div>
                    <input @click="openMenu" type="text"
                           class="input">
                </div>
                <div
                    class="menu"
                    :class="{'active': isOpenMenu}"
                >
                    <div v-if="isLoading" class="text-white text-center">Loading...</div>
                    <a href="" v-for="user in users" class="flex items-center mb-4 last:mb-0">
                        <img v-if="user.avatar" class="w-10 h-10" :src="'/storage/images/uploads/' + user.avatar" alt="">
                        <img v-else class="w-10 h-10" src="/storage/images/default/avatar-default.png" alt="">
                        <div class="ps-3">
                            <div class="text-white">{{user.name}}</div>
                            <div class="text-white">{{user.email}}</div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </header>
</template>

<script setup>

import {useStore} from "vuex";
import {computed, onMounted, ref} from "vue";
import types from "../../../store/search/types.js";

const store = useStore()

const users = computed(() => store.state.search.users)
const isLoading = computed(() => store.state.search.isLoading)

const isOpenMenu = ref(false)
const wasInit = ref(false)

onMounted(() => {
    window.addEventListener('click', (e) => {
        if (
            isOpenMenu.value
            && !e.target.closest('.menu.active')
            && !e.target.closest('.input')
        ) {
            closeMenu()
        }
    })
})

const openMenu = () => {
    isOpenMenu.value = true

    if (!wasInit.value) {
        store.dispatch('search/' + types.INIT)
        wasInit.value = true
    }
}

const closeMenu = () => {
    isOpenMenu.value = false
}

</script>

<style lang="scss" scoped>
.input {
    @apply
    transition
    focus:border-neutral-900
    bg-gray-800
    px-3 w-60
    caret-white
    text-white
    rounded-lg
    border
    border-neutral-900

    h-9
    block
    text-white
    font-medium

}
.menu {

    @apply
    overflow-y-auto
    opacity-0
    invisible
    p-4
    absolute
    z-10
    top-full
    min-h-full
    left-0
    h-60
    w-full
    rounded-lg
    border-neutral-900
    border
    translate-y-2.5
    ease-out
    duration-300
    bg-gray-800;


    &.active {
        @apply opacity-100 visible translate-y-1.5
    }
}
</style>


