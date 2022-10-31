<template>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Account</h4>
                        <div class="card">
                            <div class="card-body">
                                <h6>Personal Information</h6>
                                <hr class="my-4">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>First Name</label>
                                        <input class="au-input au-input--full" type="text"  v-model="post.first_name"  placeholder="First Name">
                                        <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Last name</label>
                                        <input class="au-input au-input--full" type="text"  v-model="post.last_name"  placeholder="Last Name">
                                        <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Username</label>
                                        <input class="au-input au-input--full" type="text"  v-model="post.username"  placeholder="Username">
                                        <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                                    </div>
                                </div>
                                
                                <button type="button" @click="savePersonal" class="btn btn-primary btn-sm">{{btncap_}}</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Change Password</h6>
                                <hr class="my-4">
                                    <div class="row gx-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputEmailAddress">New Password</label>
                                            <input class="form-control" v-model="post_.password" type="password">
                                            <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLocation">Password Confirmation</label>
                                            <input class="form-control" v-model="post_.password_confirmation" id="inputLocation" type="password">
                                            <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                                        </div>
                                    </div>
                                <button type="button" @click="savePassword" class="btn btn-primary btn-sm">{{btncap}}</button>
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
            post_:{},
            setting:{},
            errors:[],
            btncap:'Save',
            btncap_:'Save'
        }
    },
    methods: {
        savePassword(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = 'Saving ...';
                this.$axios.post('api/user-password', this.post_).then(res=>{
                    this.btncap = 'Save';
                     this.errors = [];
                     this.post_ = {};
                }).catch(err=>{
                    this.btncap = 'Save';
                    this.errors = err.response.data.errors
                });
            });
        },
        savePersonal(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap_ = 'Saving ...';
                this.$axios.post('api/admin-profile',this.post).then(res=>{
                    this.btncap_ = 'Save';
                    this.post = res.data;
                    this.errors = [];
                }).catch(err=>{
                    this.btncap_ = 'Save';
                    this.errors = err.response.data.errors
                });
            });
        },
       
    },
    mounted(){
        let user = window.Laravel.user;
        this.post = user;
    }
}
</script>

<style>

</style>
