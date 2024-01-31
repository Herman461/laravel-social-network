<template>

    <div class="bg-black min-h-full min-h-screen pb-16">
        <BaseHeader />
        <BaseNotification />
        <main class="md:container flex mx-auto pt-5">
            <BaseSidebar />
            <div class="flex-auto ps-8">
                <slot></slot>
            </div>

        </main>
    </div>

</template>
<script setup>
import BaseNotification from "./BaseNotification.vue";
import BaseSidebar from "./BaseSidebar.vue";
import BaseHeader from "../Header/BaseHeader.vue";

</script>
