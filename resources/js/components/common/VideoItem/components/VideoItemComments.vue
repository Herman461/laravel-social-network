<template>
    <div
        class="transition duration-500 absolute h-full bg-neutral-900 top-0 opacity-0 rounded-md comments flex flex-col"
        :class="{'active': props.isCommentBlockActive}"
    >
        <div class="w-full h-full overflow-auto py-3 px-2 flex-auto">
            <div :key="comment.id" v-for="comment in props.comments" class="comments-item flex mb-3">
                <BaseAvatar :slug="comment.user.slug" :has-pulse="false" size="3rem" />
                <div class="pt-1 pl-2">
                    <div class="text-[12px] font-medium mb-1">{{comment.user.name}}</div>
                    <div class="text-[12px] leading-tight">{{comment.comment.content}}</div>
                </div>
            </div>
        </div>
        <form class="relative comment-input w-full min-h-[3rem] bg-neutral-900 shrink-0 grow p-2">
            <div class="w-full relative">
                <div
                    ref="editable"
                    @keydown="onInputKeyDown"
                    @input="onInputChange"
                    @blur="onInputBlur"
                    @focus="onInputFocus"
                    contenteditable="true"
                    class="editable"
                    :class="{focus: state.hasInputFocus}"
                >

                </div>
                <div :class="{invisible: state.hidePlaceholder, 'opacity-0': state.hidePlaceholder}" class="pointer-events-none select-none absolute top-1/2 -translate-y-1/2 left-2">Leave a comment</div>

            </div>
            <div class="flex">
                <BaseButton
                    :disabled="state.disabledSubmitButton"
                    class="!text-base flex-auto !h-9 rounded-md font-medium"
                    text="Send comment"
                />
                <div @mousedown.prevent="" @click="toggleEmojiBox" class="w-10 shrink-0 cursor-pointer inline-flex items-center justify-center group">
                    <EmojiIcon viewBox="0 0 25 25" class="w-6 h-6 text-pink-700 group-hover:text-pink-600 transition-all select-none" />
                </div>
            </div>


            <div
                @mousedown.prevent=""
                class="emoji-box"
                :class="{active: state.showEmojiBox}"
            >
                <div v-for="(num, index) in 7" class="emoji-box-item">
                    <img
                        alt=""
                        src="/storage/images/default/emojis.png"
                        @click="setCommentIcon"
                        class="base-emoji-icon"
                        :style="{'object-position': `${index * -24}px 0`}"
                    />

<!--                    <div @click="setCommentIcon" class="base-emoji-icon" :style="{background: `url('/storage/images/default/emojis.png') ${index * -24}px 0 / auto no-repeat`}"></div>-->
                </div>

            </div>
        </form>
    </div>
</template>

<script setup>

import BaseAvatar from "../../BaseAvatar.vue";
import {reactive, ref} from "vue";
import EmojiIcon from '../../../../../images/icons/emoji.svg?component';
import BaseButton from "../../BaseButton.vue";

const state = reactive({
    scrollLeft: 0,
    scrollTop: 0,
    hidePlaceholder: false,
    hasEventListener: false,
    showEmojiBox: false,
    commentInput: '',
    disabledSubmitButton: true,
    hasInputFocus: false
})


const props = defineProps({
    isCommentBlockActive: {
        type: Boolean,
        default: false
    },
    comments: {
        type: Array,
        default: []
    }
})

const editable = ref(null)

const validateInput = () => {
    state.disabledSubmitButton = state.commentInput.length < 3;
}

const setCommentIcon = (e) => {

    const image = e.currentTarget.cloneNode();

    // image.src = "/storage/images/default/emojis/favorite.svg";
    const selection = window.getSelection();

    if (selection.rangeCount === 0 ||
        !editable.value.contains(selection.getRangeAt(0).commonAncestorContainer)
    ) {
        editable.value.appendChild(image);

    } else {
        console.log(selection)
        let range = selection.getRangeAt(0);

        range.collapse(false);

        range.insertNode(image);


        selection.removeAllRanges();
        range.setStartAfter(image);
        selection.addRange(range);
    }
    state.commentInput = editable.value.innerHTML

    state.hidePlaceholder = state.commentInput.length !== 0
    validateInput()
}

const hideEmojiBox = (e) => {
    if (!e.target.closest('.emoji-box') && !e.target.closest('.editable')) {
        state.showEmojiBox = false
        document.body.removeEventListener('click', hideEmojiBox)
    }
}
const toggleEmojiBox = () => {
    state.showEmojiBox = !state.showEmojiBox

    if (state.showEmojiBox) {
        setTimeout(() => {
            document.body.addEventListener('click', hideEmojiBox)
        }, 150)

    }
}
const stopScroll = () => {
    window.scrollTo(state.scrollLeft, state.scrollTop);
}

const onInputFocus = () => {
    state.hidePlaceholder = true
    state.hasInputFocus = true
    state.scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
    state.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    window.addEventListener('scroll', stopScroll)
    state.hasEventListener = true

    window.addEventListener('wheel', function() {
        state.scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        state.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        window.removeEventListener('scroll', stopScroll)
        state.hasEventListener = false
    })
}
const onInputBlur = () => {
    window.removeEventListener('scroll', stopScroll)
    state.hasEventListener = false
    state.hasInputFocus = false

    state.hidePlaceholder = state.commentInput.length !== 0
}



const onInputChange = () => {

    state.commentInput = editable.value.innerHTML



    if (!state.hasEventListener) {

        state.scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        state.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        window.addEventListener('scroll', stopScroll)
        state.hasEventListener = true
    }

    validateInput()
}
const onInputKeyDown = () => {
    if (!state.hasEventListener) {

        state.scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;
        state.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        window.addEventListener('scroll', stopScroll)
        state.hasEventListener = true
    }

}
</script>

<style lang="scss" scoped>
.comments {
    @apply border border-solid border-black;
    //width: 100%;
    right: 0.4rem;
    width: calc(100% - 14px);
    //width: calc(100% - 20px);
    //@apply -translate-x-full;
    &.active {
        right: -0.45rem;
        //width: 100%;
        @apply translate-x-full opacity-100;
    }
}

.emoji-box {

    @apply flex items-center absolute translate-y-full h-12 p-2 bg-neutral-950 border-pink-700 border-2 rounded-md border-solid w-full -bottom-4 opacity-0 invisible left-0 transition-all;
    &.active {
        @apply opacity-100 visible bottom-0;
    }
}

.editable {
    @apply leading-7 transition-all duration-300 mb-3 cursor-text w-full min-h-[3rem] max-h-[92px] overflow-y-auto caret-pink-700 py-2 px-2 border-2 border-solid border-pink-700 bg-neutral-950 rounded-md;
    &.focus {
        @apply bg-black;
    }
}

.comment-input-placeholder {
    @apply pointer-events-none select-none absolute top-1/2 -translate-y-1/2 left-2;
    &.hidden {
        @apply invisible opacity-0;
    }
}
.emoji-box-item {

    @apply h-8 w-8 inline-flex justify-center items-center cursor-pointer
}
.base-emoji-icon {
    @apply w-6 h-6 object-cover;
}
.editable {
    .base-emoji-icon {
        display: inline-block;
    }
}
</style>
