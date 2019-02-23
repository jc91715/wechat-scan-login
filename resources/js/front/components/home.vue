<template>
    <!--<transition :name="viewTransition">-->
        <router-view></router-view>
    <!--</transition>-->
　　　
</template>

<script>
    export default {
        data(){
            return {
                message : 'hello home.vue',
            }
        },
        beforeRouteUpdate (to, from, next) {
            if(this.$route.path!='/home') //假设name为home的路由都使用`slide-left`,其它的路由都为`slider-right`
            {
                this.$store.commit('set_common_direction','forward');
            }else {

            }
            next()
        },
        beforeRouteLeave(to, from, next){
           console.log('离开')
            next()
        },
        computed:{
            direction(){
                return this.$store.state.common.direction
            },
            viewTransition () {
                if (!this.direction) return ''
                return 'vux-pop-' + (this.direction === 'forward' ? 'in' : 'out')
            }
        },

        mounted() {
        },
        methods:{

        }
    }
</script>
<style>
    * {
        margin: 0px;
        padding: 0px;
    }
    .slide-left-enter,
    .slide-right-leave-active {
        opacity: 0;
        -webkit-transform: translate(100%, 0);
        transform: translate(100%, 0);
    }

    .slide-left-leave-active,
    .slide-right-enter {
        opacity: 0;
        -webkit-transform: translate(-100%, 0);
        transform: translate(-100% 0);
    }


</style>
