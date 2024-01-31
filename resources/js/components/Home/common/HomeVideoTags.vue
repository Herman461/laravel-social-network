<template>
    <div class="text-xl font-medium flex items-center mb-5">
        <slot name="icon"></slot>
        {{props.title}}
    </div>
    <div class="flex flex-wrap justify-center -mx-1 mb-10">
        <div class="px-1 mb-2" :key="tag.tag_id" v-for="tag in tags">
            <RouterLink :to="'/tags/' + tag.slug"  class="leading-5 base-tag inline-flex flex-col justify-center items-center text-center bg-pink-700 rounded-md py-1 px-3 text-lg min-h-12">
                {{tag.name}}
                <span class="text-sm leading-none mt-1">{{tag.tag_count}} vids</span>
            </RouterLink>
        </div>

    </div>
</template>


<script setup>


import {computed} from "vue";
import store from "../../../../store/store.js";
import types from "../../../../store/home/types.js";

const tags = computed(() => store.state.home.tags)

store.dispatch('home/' + types.GET_TAGS)
const props = defineProps({

    title: {
        type: String,
        required: true
    }
})

</script>


<style scoped lang="scss">
.home-feed-bottom {
    @apply flex justify-center relative mt-3 mb-10;
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

.base-tag {
    box-shadow: 0 0 25px rgba(255, 0, 122, 0.5);
}
</style>
