import Profile from './components/Pages/Profile.vue'
import Messenger from './components/Pages/Messenger.vue'
import Login from './components/Pages/Login.vue'
import {createRouter, createWebHistory} from 'vue-router'
import {getCookie} from "./helpers.js";



const routes = [
    { path: '/profile/:slug?', component: Profile, name: 'profile', meta: {requiresAuth: true} },
    { path: '/im', component: Messenger, name: 'messenger' },
    { path: '/login', component: Login, name: 'login' },
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
