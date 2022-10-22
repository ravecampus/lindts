<template>
    <div class="container py-5 m-top">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Change Password</div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="inputEmailAddress">New Password</label>
                                <input class="form-control" v-model="post_.password" type="password">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-12">
                                <label class="small mb-1" for="inputLocation">Password Confirmation</label>
                                <input class="form-control" v-model="post_.password_confirmation" id="inputLocation" type="password">
                                <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="book-a-table-btn" @click="savePasword()" type="button">{{btncap1}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Profile Settings</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Group (username)-->
                            <div class="mb-3">
                                <label class="small mb-1">Username</label>
                                <input class="form-control" v-model="post.username" type="text" placeholder="Enter your username">
                                <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1">First name</label>
                                    <input class="form-control" v-model="post.first_name" type="text" placeholder="Enter your first name">
                                    <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" >Last name</label>
                                    <input class="form-control" v-model="post.last_name" type="text" placeholder="Enter your last name">
                                    <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>
                                </div>
                            </div>
                            <!-- Form Row        -->
                            <div class="mb-3">
                                <label class="small mb-1" >Address</label>
                                <input class="form-control" v-model="post.address" type="text" placeholder="Enter your address">
                                <span class="errors-material" v-if="errors.address">{{errors.address[0]}}</span>
                            </div>
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (organization name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" >Email address</label>
                                    <input class="form-control" v-model="post.email" type="text" placeholder="Enter your email address">
                                    <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                                
                                </div>
                                <!-- Form Group (location)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Age</label>
                                    <input class="form-control" v-model="post.age" type="text" placeholder="Enter your age">
                                    <span class="errors-material" v-if="errors.age">{{errors.age[0]}}</span>
                                </div>
                            </div>
                            <!-- Form Group (email address)-->
                            
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" >Mobile number</label>
                                    <input class="form-control" v-model="post.mobile_number" type="text" placeholder="Enter your mobile number">
                                    <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="book-a-table-btn" @click="saveProfile()" type="button">{{ btncap }}</button>
                        </form>
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
            errors:[],
            btncap:'Save Changes',
            btncap1:'Save Changes'
        }
    },
    methods:{
        saveProfile(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = "Saving...";
                this.$axios.post('api/user-profile', this.post).then(res=>{
                    this.btncap = "Save Changes";
                    this.errors = [];
                    this.post = res.data;
                }).catch(err=>{
                    this.btncap = "Save Changes";
                    this.errors = err.response.data.errors
                });
            });
        },
        savePasword(){
           this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap1 = "Saving...";
                this.$axios.post('api/user-password', this.post_).then(res=>{
                    this.btncap1 = "Save Changes";
                    this.post_ = {};
                    this.errors = [];
                    // this.post = res.data;
                }).catch(err=>{
                    this.btncap1 = "Save Changes";
                    this.errors = err.response.data.errors
                });
            }); 
        }
    },
    mounted(){
       if(window.Laravel.isLoggedin){
            let user = window.Laravel.user
            this.post = user;
        }
    }
}
</script>

<style>

</style>
