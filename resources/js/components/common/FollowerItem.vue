<template>
    <div class="flex items-center min-h-[8rem] max-w-[1000px] bg-neutral-900 rounded-lg pt-4 pl-4 pr-4 pb-4">
        <base-avatar />
        <div class="text-white ml-4 text-lg flex-auto">Herman461</div>
        <div class="inline-flex items-center">
            <div class="group cursor-pointer w-10 h-10 mr-6">
                <MessagingIcon class="group-hover:scale-95 transition text-pink-700 w-10 h-10" />
            </div>
            <div class="transition hover:scale-95 cursor-pointer w-10 h-10 rounded-full bg-pink-700 inline-flex items-center justify-center">
                <AngleRightIcon class="text-white" />
            </div>
        </div>
    </div>
</template>

<script setup>
import MessagingIcon from '../../../images/icons/messaging.svg?component';
import AngleRightIcon from '../../../images/icons/angle-right.svg?component';
import BaseAvatar from "../common/BaseAvatar.vue";
</script>

<style scoped lang="scss">

</style>
