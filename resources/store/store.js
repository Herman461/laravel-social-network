import {createStore} from "vuex";
import search from "./search/search.js";
import posts from "./posts/posts.js";
import auth from "./auth/auth.js";
import profile from "./profile/profile.js";
import videos from "./videos/videos.js";

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

    actions,
    mutations,
    modules: {
        search,
        posts,
        auth,
        profile,
        videos
    }

})


export default store
