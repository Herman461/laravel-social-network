<template>
    <div class="bg-black min-h-full min-h-screen">
        <base-header />

        <main class="md:container flex mx-auto">
            <base-sidebar />
            Home
        </main>
    </div>
</template>

<script setup>
import BaseHeader from "../Header/Header.vue";
import BaseSidebar from "../common/BaseSidebar.vue";
import {onBeforeRouteLeave} from "vue-router";


</script>
