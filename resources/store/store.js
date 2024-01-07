import {createStore} from "vuex";
import search from "./search/search.js";
import posts from "./posts/posts.js";
import auth from "./auth/auth.js";

const mutations = {
    SET_USER(state, payload) {
        state.user = payload.user
    }
}

const actions = {
    GET_USER({commit}, slug) {
        axios.get('/api/profile/user/' + slug)
            .then(response => {
                console.log(response)
                // commit('SET_USER', response.data.data)
            })
    }
}
const store = createStore({
    strict: process.env.NODE_ENV !== 'production',
    state() {
        return {
            isAuthenticated: false,

        }
    },
    actions,
    mutations,
    modules: {
        search,
        posts,
        auth
    }

})


export default store
