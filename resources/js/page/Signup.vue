<template>
   
    <div class="page-wrapper">
        <div class="page-content--bge5 mb-5 signup-size">
            <div class="container">
                <div class="login-wrap sign-w">
                    <div class="login-content">
                        <div class="login-logo">
                            <router-link :to="{name:'dashboard'}">
                                <img :src="'../images/icon/iconlidts.png'" alt="Lindt's Food">
                            </router-link>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>First name</label>
                                        <input type="text" v-model="post.first_name" class="form-control">
                                        <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Last name</label>
                                        <input type="text" v-model="post.last_name" class="form-control">
                                        <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Age</label>
                                        <input type="number" v-model="post.age" class="form-control">
                                        <span class="errors-material" v-if="errors.age">{{errors.age[0]}}</span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Mobile number</label>
                                        <input type="text" v-model="post.mobile_number" class="form-control">
                                        <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" v-model="post.address" class="form-control">
                                    <span class="errors-material" v-if="errors.address">{{errors.address[0]}}</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Username</label>
                                        <input type="text" v-model="post.username" class="form-control">
                                        <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Email</label>
                                        <input type="text" v-model="post.email" class="form-control">
                                        <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label>Password</label>
                                        <input type="password" v-model="post.password" class="form-control">
                                        <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label>Password Confirmation</label>
                                        <input type="password" v-model="post.password_confirmation" class="form-control">
                                        <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                                    </div>
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="aggree">Agree the terms and policy
                                    </label>
                                </div>
                                <button @click="signup()" class="btn btn-warning btn-block text-white" :disabled="btn_dis" type="button">{{ btn_txt }}</button>
                               
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <router-link :to="{name:'signin'}">Sign In</router-link>
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
            btn_txt:"sign up",
            btn_dis: false
        }
    },
    methods:{
        signup(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_txt = "Submitting..."
                this.btn_dis = true
                this.$axios.post('api/signup', this.post).then(res=>{
                    this.btn_txt = "sign up"
                    this.btn_dis = false;
                    this.$router.push({name:'signin'});
                }).catch(err=>{
                    this.btn_txt = "sign up"
                    this.btn_dis = false;
                    this.errors = err.response.data.errors
                });
            });
        }
    }
}
</script>

<style>

</style>
