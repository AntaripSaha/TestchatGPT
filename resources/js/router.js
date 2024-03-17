import { createWebHashHistory, createRouter } from "vue-router";

import home from './pages/home.vue';
import login from './pages/login.vue';
import register from './pages/register.vue';
import chatgpt from './pages/chatgpt.vue';

const routes = [
    {
        path : '/',
        name : 'Home',
        component : home 
    },
    {
        path : '/login',
        name : 'Login',
        component : login,
        meta :{
            requiresAuth: false
        }
    },
    {
        path : '/register',
        name : 'Register',
        component : register,
        meta :{
            requiresAuth: false
        }
    },
    {
        path : '/chatgpt',
        name : 'ChatGpt',
        component : chatgpt,
        meta :{
            requiresAuth: true
        }
    },
];

const router = createRouter ({
    history : createWebHashHistory(),
    routes
});

router.beforeEach((to, from) => {
    if (to.meta.requiresAuth && !localStorage.getItem('token')) {
        return {name : 'Login'}
    }
    if (to.meta.requiresAuth == false && localStorage.getItem('token')) {
        return {name : 'Chatgpt'}
    }
})

export default router;