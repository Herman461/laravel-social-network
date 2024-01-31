import types from "./types.js";
import {http} from '../../js/axios.js'

import router from "../../js/routes.js";
import {deleteCookie} from "../../js/helpers.js";
import store from "../store.js";

const state = {
    videos: {
        'new-home': [],
        'trending-home': [],
        'profile': []
    },
    unloadedVideos: {
      'new-home': [],
      'trending-home': [],
    },
    allowSound: false,
    videoSpeed: 1.0,
    isFullscreen: false,
    lastPage: null,
    isCommentsOpened: false
}

const mutations = {
    [types.TOGGLE_IS_COMMENTS_OPENED](state) {
        state.isCommentsOpened = !state.isCommentsOpened
    },
    [types.TOGGLE_IS_LOADING](state) {
      state.isLoading = !state.isLoading
    },


    [types.SET_VIDEOS](state, payload) {

        state.videos[payload.category].push(...payload.videos)
    },
    [types.SET_COMMENTS](state, payload) {
        state.videos[payload.category][payload.index].comments.push(...payload.comments)
    },
    [types.TOGGLE_SOUND](state) {
        state.allowSound = !state.allowSound
    },
    [types.UPDATE_VIDEO_SPEED](state, payload) {
        state.videoSpeed = payload.videoSpeed
    },
    [types.TOGGLE_IS_FULLSCREEN](state) {
        state.isFullscreen = !state.isFullscreen
    },
    [types.TOGGLE_SHOW_VIDEOS](state, payload) {
        if (state.unloadedVideos[payload.category].length > 0) {
            state.videos[payload.category].push(...state.unloadedVideos[payload.category])
            state.unloadedVideos[payload.category] = []
        } else {
            if (state.videos[payload.category].length > 5) {
                state.unloadedVideos[payload.category] = state.videos[payload.category].slice(5)
                state.videos[payload.category] = state.videos[payload.category].slice(0, 5)
            }
        }
    },
    [types.SET_LAST_PAGE](state, payload) {
        state.lastPage = payload
    },
    [types.SET_HOME_VIDEOS](state, payload) {
        state.videos[payload.category].push(...payload.videos.slice(0, 5))
        state.unloadedVideos[payload.category].push(...payload.videos.slice(5))
    }
}

const actions = {


    async [types.GET_VIDEOS]({commit, state}, payload) {

        const response = await http.get(`videos/${store.state.profile.user.id}`, {
            params: {
                'per-page': payload.perPage,
                page: payload.page,
            }

        })

        if (response.status === 200) {
            commit(types.SET_VIDEOS, {videos: response.data.data, category: payload.category})

            if (!state.lastPage) {
                commit(types.SET_LAST_PAGE, response.data.meta.last_page)
            }
        }

    },

    [types.INCREMENET_VIEWS]({}, payload) {
        http.patch(`videos/views/${payload.videoId}`)
    },

    async [types.UPLOAD_COMMENTS]({commit, state}, payload) {
        const response = await http.get(`videos/comments/${payload.videoId}`, {
            params: {
                'per-page': payload.perPage,
                page: payload.page,
            }
        })
        if (response.status === 200) {

            commit(types.SET_COMMENTS,
                {
                    index: payload.index,
                    comments: response.data.data,
                    category: payload.category
                });
        }

    },
    async [types.GET_NEW_VIDEOS]({commit}, payload) {
        const response = await http.get("home/videos/new")


        commit(types.SET_HOME_VIDEOS, {videos: response.data.data, category: payload.category})
    },

    async [types.GET_TRENDING_VIDEOS]({commit}, payload) {
        const response = await http.get("home/videos/trending")


        commit(types.SET_HOME_VIDEOS, {videos: response.data.data, category: payload.category})
    },

}

export default {
    namespaced: true,
    state,
    mutations,
    actions
}
