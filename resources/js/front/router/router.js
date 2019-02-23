

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes=[
    {
        path: '/', component: require('../components/home.vue') ,name: 'home',
        children: [
            {
                path: 'wechat',component: require('../components/home.vue'),
                children: [
                    { path: ':code/login',component: require('../login/wechat.vue') ,name: 'wechat.login.index' },
                ]
            }
        ]
    },

];

const router = new VueRouter({
    mode: 'history',
    routes
})
export default router
