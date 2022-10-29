<template>
    
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <router-link :to="{name:'dashboard'}">
                                <img :src="'../images/icon/iconlidts.png'" alt="CoolAdmin">
                            </router-link>
                        </div>
                        <div class="login-form">
                            <div class="alert alert-danger p-0" v-if="errors.errs">
                                <div class="alert errors-material m-0">
                                    <div v-if="errors.errs"><strong>*</strong>{{errors.errs[0]}}</div>
                                </div>
                            </div>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" @keyup.enter="signin" type="text" v-model="post.username"  name="username" placeholder="Username">
                                    <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                                   
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input class="au-input au-input--full" @keyup.enter="signin" type="password"  v-model="post.password" name="password" placeholder="Password">
                                    <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>

                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="remember">Remember Me
                                    </label>
                                    <label>
                                        <a href="#">Forgotten Password?</a>
                                    </label>
                                </div>
                                <button  type="button" class="btn btn-warning btn-block text-white"  @click="signin()" :disabled="btn_dis">{{ btn_txt}}</button>
                                <!-- <div class="social-login-content">
                                    <div class="social-button">
                                        <button class="au-btn au-btn--block au-btn--blue m-b-20">sign in with facebook</button>
                                        <button class="au-btn au-btn--block au-btn--blue2">sign in with twitter</button>
                                    </div>
                                </div> -->
                            </form>
                            <div class="register-link">
                                <p>
                                    Don't you have account?
                                    <a href="#" @click="linkSignup">Sign Up Here</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            post:{},
            errors:[],
            btn_txt:"sign in",
            btn_dis: false
        }
    },
    methods:{
        signin(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_txt = "Accessing..."
                this.btn_dis = true;
                this.$axios.post('api/signin', this.post).then(res=>{
                    this.btn_txt = "sign in"
                    this.btn_dis = false;
                    let data = res.data;
                    if(data.role == 1){
                        window.location.href="/admin"
                    }else{
                        window.location.href="/"
                    }
                  
                }).catch(err=>{
                    this.btn_dis = false;
                    this.btn_txt = "sign in"
                    this.errors = err.response.data.errors
                });
            });
        },
        linkSignup(){
            this.$router.push({name:'signup'});
        }
    },
    mounted() {
        if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.auth = true;
            if(user.role == 1){
                this.$router.push({name:'admin'})
            }else {
               this.$router.push({name:'dashboard'})
            }
        }
    },
}
</script>

<style>

</style>
