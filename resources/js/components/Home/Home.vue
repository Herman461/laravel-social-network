<template>
    <BaseWrapper>
        <HomeVideoFeed
            category="new-home"
            title="New Videos"
            :videos="newVideos"
        >
            <template v-slot:icon>
                <LightningIcon height="30" width="30" class="text-pink-700 mr-2" />
            </template>
        </HomeVideoFeed>
        <HomeVideoTags title="Trending Tags">
            <template v-slot:icon>
                <TrendingUpIcon viewBox="0 0 24 24" height="35" width="35" class="text-pink-700 mr-1" />
            </template>
        </HomeVideoTags>
        <HomeVideoFeed
            category="trending-home"
            title="Trending Videos"
            :videos="trendingVideos"
        >
            <template v-slot:icon>
                <FireIcon viewBox="0 0 24 24" height="35" width="35" class="text-pink-700 mr-1" />
            </template>
        </HomeVideoFeed>

    </BaseWrapper>
</template>

<script setup>
import BaseWrapper from "../common/BaseWrapper.vue";
import HomeVideoFeed from "./common/HomeVideoFeed.vue";

import store from "../../../store/store.js";
import types from "../../../store/videos/types.js";

import LightningIcon from '../../../images/icons/lightning.svg?component';
import FireIcon from '../../../images/icons/fire.svg?component';
import TrendingUpIcon from '../../../images/icons/trending-up.svg?component';

import {computed} from "vue";
import HomeVideoTags from "./common/HomeVideoTags.vue";




store.dispatch('videos/' + types.GET_NEW_VIDEOS, {category: 'new-home'})
store.dispatch('videos/' + types.GET_TRENDING_VIDEOS, {category: 'trending-home'})

const newVideos = computed(() => store.state.videos.videos['new-home'])
const trendingVideos = computed(() => store.state.videos.videos['trending-home'])
</script>


