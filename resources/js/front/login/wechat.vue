<template>
    <div>
        <div v-if="state">
            {{msg}}
        </div>
        <div v-else>
            <h3 class="confirm" @click="confirm_login" >确认登录</h3>
            <h3 class="cancel" @click="cancel_login">取消登录</h3>
        </div>

    </div>
</template>

<script>
    export default {
        name: "confirm",
        props:['code'],
        data(){
            return {
                state: false,
                msg:''
            }
        },
        methods:{
            confirm_login(){
                axios.post(Laravel.router('api.home.wechat.confirm_login'),{code:this.code}).then(res=>{
                    this.state = true
                    this.msg = res.data.msg
                })
            },
            cancel_login(){
                axios.post(Laravel.router('api.home.wechat.cancel_login'),{code:this.code}).then(res=>{
                    this.state = true
                    this.msg = res.data.msg
                })
            }
        },
        created(){
            axios.post(Laravel.router('api.home.wechat.login_code_state'),{code:this.code}).then(res=>{
                if(res.data.errorCode){
                    this.state = true
                    this.msg = res.data.msg
                }
            })
        }
    }
</script>

<style scoped>
    .confirm{
        margin-top: 50px;
        text-align: center;
    }
    .cancel{
        margin-top: 30px;
        color: red;
        text-align: center;
    }
</style>
