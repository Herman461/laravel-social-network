<template>
    <div class="bg-black py-6 px-4 min-h-full min-h-screen flex flex-col justify-center items-center">
        <form @submit="login" class="base-block">
            <BaseInput id="email" label="E-mail" v-model="state.email"/>
            <BaseInput id="password" type="password" label="Password" v-model="state.password"/>
            <BaseButton text="Login"/>
        </form>

    </div>
</template>

<script setup>

import BaseInput from "../common/BaseInput.vue";
import {reactive} from "vue";
import BaseButton from "../common/BaseButton.vue";
import {useStore} from "vuex";
import types from "../../../store/auth/types.js";
import {getCookie} from "../../helpers.js";
import router from "../../routes.js";

if (getCookie('access_token')) {
    router.push('/profile')
}
const state = reactive({
    email: '',
    password: ''
})

const store = useStore()



const login = (e) => {
    store.dispatch('auth/' + types.LOGIN,
        {email: state.email, password: state.password}
    )

    e.preventDefault()
}

</script>


<style scoped lang="scss">
.base-block {
    @apply max-w-2xl w-full
    rounded-md min-h-[24rem]
    bg-neutral-900 px-8 py-12
    flex w-full justify-center flex-col

}


</style>
