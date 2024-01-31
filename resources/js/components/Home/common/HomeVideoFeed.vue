<template>
    <div class="text-xl font-medium flex items-center mb-5">
        <slot name="icon"></slot>

        {{props.title}}
    </div>
    <BaseVideoFeed category="new-home" :cols="5" :videos="props.videos" />
    <div class="home-feed-bottom">
        <BaseButton
            @click="toggleShowVideos"
            type="button"
            class="!w-1/3 !h-12 !text-lg rounded-md font-medium items-center"
            :text="state.isShowedAllFeed ? 'Show less' : 'Show more'"
        >
            <template v-slot:icon>
                <div

                    class="ml-2 mt-1"
                >
                    <AngleDownIcon
                        :class="{'-rotate-180': state.isShowedAllFeed}"
                        class="transition-all duration-500"
                        viewBox="0 0 21 24"
                        height="20"
                        width="20"
                    />
                </div>

            </template>
        </BaseButton>
    </div>

</template>


<script setup>
import AngleDownIcon from '../../../../images/icons/angle-down.svg?component';
import BaseVideoFeed from "../../common/BaseVideoFeed.vue";

import {reactive} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/videos/types.js";
import BaseButton from "../../common/BaseButton.vue";

const props = defineProps({
    videos: {
        type: Array,
        default: []
    },
    title: {
        type: String,
        required: true
    },
    category: {
        type: String,
        required: true
    }
})
const state = reactive({
    isShowedAllFeed: false
})

const toggleShowVideos = () => {
    store.commit('videos/' + types.TOGGLE_SHOW_VIDEOS, {category: props.category})
    state.isShowedAllFeed = !state.isShowedAllFeed
}
</script>


<style scoped lang="scss">
.home-feed-bottom {
    @apply flex justify-center relative mt-3 mb-12;
    &::before,
    &::after {
        content: "";
        position: absolute;
        top: 50%;
        transform: translate(0, -50%);
        height: 1px;
        background: #FF007A;
        width: 33.333%;
    }
    &::before {
        left: 0;
    }
    &::after {
        right: 0;
    }
}
</style>
