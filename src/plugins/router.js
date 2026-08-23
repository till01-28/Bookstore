import{createRouter, createWebHistory} from "vue-router";
import {defineAsyncComponent} from "vue";


const routes = [
    {
        path: '/',
        component: () => import('@/pages/HomePage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        }
    },
    {
        path: '/login',
        component: () => import('@/pages/LoginPage.vue'),
        meta: {
            layout: defineAsyncComponent(() => import('@/layouts/BlankLayout.vue'))
        }
    },
    {
        path: '/register',
        component: () => import('@/pages/SignUpPage.vue'),
        meta: {
            layout: defineAsyncComponent(() => import('@/layouts/BlankLayout.vue'))
        }
    },
    {
        path: '/user-info',
        component: () => import('@/pages/UserInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        }
    },
    {
        path: '/company-info',
        component: () => import('@/pages/CompanyInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        }
    },
    {
        path: '/clients-info',
        component: () => import('@/pages/ClientsInfoPage.vue'),
        meta:{
            layout: defineAsyncComponent( () => import('@/layouts/DefaultLayout.vue'))
        }
    },

]
export default createRouter({
    history: createWebHistory(),
    routes
})

