<template>
    <div class="bg-black min-h-full min-h-screen">
        <base-header />

        <main class="md:container flex mx-auto pt-5">
            <base-sidebar />
            <div class="flex-auto ps-8">
                <FollowerItem class="mb-6" />
                <FollowerItem class="mb-6" />
                <FollowerItem class="mb-6" />
                <FollowerItem class="mb-6" />
                <FollowerItem class="mb-6" />
                <FollowerItem class="mb-6" />
            </div>
        </main>
    </div>

</template>

<script setup>

import BaseHeader from "../Header/Header.vue";
import {computed} from "vue";
import types from "../../../store/posts/types.js";

import BaseSidebar from "../common/BaseSidebar.vue";
import FollowerItem from "../common/FollowerItem.vue";


</script>

<style lang="scss">

</style>

