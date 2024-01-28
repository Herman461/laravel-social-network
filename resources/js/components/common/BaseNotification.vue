<template>
    <div :class="{active: state.isActive}" ref="notification" class="base-notification z-[9999] base-notification fixed top-4 right-0 min-h-16 w-80 bg-rose-700 rounded-l-md">
        <div class="relative flex flex-col w-full h-full p-2">
            <div class="flex items-center h-full">
                <div class="w-12 h-12 shrink-0 rounded-full bg-rose-900 inline-flex items-center justify-center">
                    <CloseIcon class="text-rose-950"  />
                </div>
                <div class="pl-3 flex flex-col">
                    <span class="text-md leading-[1.1rem]">You should login to like this video</span>
                </div>
            </div>
            <router-link class="underline self-end font-medium" v-if="props.link && props.to" :to="props.to">{{props.link}}</router-link>
            <div class="line absolute h-[3px] bottom-0 right-0 bg-white rounded-l-md"></div>
        </div>
    </div>
</template>

<script setup>
import CloseIcon from '../../../images/icons/close.svg?component';
import {reactive, ref} from "vue";

const notification = ref(null)

const state = reactive({
  isActive: false,
})
const props = defineProps({
    link: {
        type: String,
        // default: 'Login'
    },
    to: {
        type: String,
        // default: '/login'
    }
})
// window.addEventListener('click', function() {
//     state.isActive = !state.isActive
//     setTimeout(() => {
//         state.isActive = false
//     }, 5300)
// })
</script>


<style scoped lang="scss">
.base-notification {
    @apply transition duration-300;
  transform: translate(100%, 0);
    .line {
        width: 0;
    }
    &.active {
        transform: translate(0, 0);
        .line {
            animation: 5s linear 0.3s 1 running notification-slide;
        }

    }
}

@keyframes notification-slide {
    0% {
        width: 100%;
    }
    100% {
        width: 0;
    }
}
</style>
