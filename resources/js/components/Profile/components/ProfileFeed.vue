<template>
    <div class="pt-8 feed -ml-2 -mr-2">
        <VideoItem />



    </div>
</template>

<script setup>

import VideoItem from "../../common/VideoItem.vue";
</script>

<style scoped lang="scss">
.feed {
    @apply flex flex-wrap
}
</style>
