import Profile from './components/Profile/Profile.vue'
import Followers from './components/Followers/Followers.vue'
import Following from './components/Following/Following.vue'

import Login from './components/Pages/Login.vue'

import Home from './components/Home/Home.vue'
import {createRouter, createWebHistory} from 'vue-router'
import {getCookie} from "./helpers.js";



const routes = [
    { path: '/profile/:slug?', component: Profile, name: 'profile', meta: {requiresAuth: false} },
    { path: '/login', component: Login, name: 'login' },
    { path: '/', component: Home, name: 'home' },
    { path: '/followers', component: Followers, name: 'followers' },
    { path: '/following', component: Following, name: 'following' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    if (to.meta.requiresAuth) {
        const token = getCookie('access_token')

        if (token) {
            next();
        } else {
            next('/login')
        }
    } else {
        next();
    }
});

export default router
