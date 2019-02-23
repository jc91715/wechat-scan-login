

import VueRouter from 'vue-router';
Vue.use(VueRouter);

const routes=[
    {
        path: '/', component: require('../components/home.vue').default ,name: 'home',
        children: [
            {
                path: 'wechat',component: require('../components/home.vue').default,
                children: [
                    { path: ':code/login',component: require('../login/wechat.vue').default ,name: 'wechat.login.index' ,props:true},
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
