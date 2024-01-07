<template>
    <div class="input-wrapper group mb-12 last:mb-0">
        <input
            :class="{ 'fix-placeholder': state.isFixPlaceholder }"
            class="input"
            @blur="togglePlaceholder"
            @input="updateValue"
            :value="props.modelValue"
            :type="type"
            :id="id"
        >
        <label :for="id" class="label">{{props.label}}</label>
    </div>
</template>


<script setup>
import {reactive} from "vue";

const props = defineProps({
    modelValue: {
        type: String,
        required: true
    },
    label: {
        type: String,
        required: true
    },
    id: {
        type: String,
        required: true
    },
    type: {
        type: String,
        default: 'text'
    }
})
const state = reactive({
    isFixPlaceholder: false
})

const emit = defineEmits(['update:modelValue'])

function updateValue(e) {
    emit('update:modelValue', e.target.value)
}
function togglePlaceholder(event) {
    const value = event.target.value

    if (value.length > 0 && !state.isFixPlaceholder) {

        state.isFixPlaceholder = true
    }

    if (value.length === 0 && state.isFixPlaceholder) {

        state.isFixPlaceholder = false
    }

}

</script>

<style lang="scss">
.input-wrapper {
    @apply relative w-full
}

.input {
    @apply block transition-all pb-3
    placeholder-white
    font-normal text-white
    w-full flex h-11
    bg-transparent border-solid
    border-b-2 caret-pink-700
    border-pink-900 focus:border-pink-700 text-2xl
}
.label {
    @apply transform transition-all
    absolute top-0 left-0
    h-full flex items-center
    pl-2 text-sm
    group-focus-within:text-xl peer-valid:text-xs
    group-focus-within:h-1/2 peer-valid:h-1/2
    group-focus-within:-translate-y-7 peer-valid:-translate-y-full
    group-focus-within:pl-0 peer-valid:pl-0
    text-2xl cursor-text
    group-focus-within:cursor-default
}

.input.fix-placeholder + .label {
    @apply text-xl peer-valid:text-xs
    h-1/2 peer-valid:h-1/2
    -translate-y-7 peer-valid:-translate-y-full
    pl-0 peer-valid:pl-0
    cursor-default
}
</style>
