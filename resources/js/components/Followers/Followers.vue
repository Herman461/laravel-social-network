<template>
    <BaseWrapper>
        <div class="flex-auto ps-8">
            <FollowerItem class="mb-6" />
            <FollowerItem class="mb-6" />
            <FollowerItem class="mb-6" />
            <FollowerItem class="mb-6" />
            <FollowerItem class="mb-6" />
            <FollowerItem class="mb-6" />
        </div>
    </BaseWrapper>

</template>

<script setup>

import {computed} from "vue";
import types from "../../../store/posts/types.js";

import FollowerItem from "../common/FollowerItem.vue";
import BaseWrapper from "../common/BaseWrapper.vue";


</script>

<style lang="scss">

</style>

