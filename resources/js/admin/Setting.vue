<template>
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <h4>Setting</h4>
                        <div class="card">
                            <div class="card-body">
                                <h6>Contact and Schedule</h6>
                                <hr class="my-4">
                                <div class="form-group">
                                    <label>Mobile number</label>
                                    <input class="au-input au-input--full" type="text"  v-model="setting.mobile_number"  placeholder="Mobile number">
                                    <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                                </div>
                                 <div class="form-group">
                                    <label>Schedule</label>
                                    <input class="au-input au-input--full" type="text"  v-model="setting.schedule"  placeholder="Mon-Sat: 8:00 AM - 5:00 PM">
                                    <span class="errors-material" v-if="errors.schedule">{{errors.schedule[0]}}</span>
                                </div>
                                <button type="button" @click="saveSetting" class="btn btn-primary btn-sm">{{btncap_}}</button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h6>Standard Delivery Fee</h6>
                                <hr class="my-4">
                                <div class="form-group">
                                    <label>Amount</label>
                                    <input class="au-input au-input--full" type="number"  v-model="post.amount"  placeholder="Amount">
                                    <!-- <span class="errors-material" v-if="errors.amount">{{errors.amount[0]}}</span> -->
                                </div>
                                <button type="button" @click="saveDeliveryFee" class="btn btn-primary btn-sm">{{btncap}}</button>
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
            setting:{},
            errors:[],
            btncap:'Save',
            btncap_:'Save'
        }
    },
    methods: {
        saveDeliveryFee(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = 'Saving ...';
                this.$axios.post('api/delivery-fee', this.post).then(res=>{
                    this.btncap = 'Save';
                }).catch(err=>{
                    this.btncap = 'Save';
                });
            });
        },
        saveSetting(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap_ = 'Saving ...';
                this.$axios.post('api/setting',this.setting).then(res=>{
                    this.btncap_ = 'Save';
                }).catch(err=>{
                    this.btncap_ = 'Save';
                    this.errors = err.response.data.errors
                });
            });
        },
         getDeliveryFee(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/delivery-fee-get').then(res=>{
                    this.post = res.data;
                });
            });
        },
        getSetting(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/setting-get').then(res=>{
                    this.setting = res.data;
                });
            });
        }
    },
    mounted(){
        this.getDeliveryFee();
        this.getSetting();
    }
}
</script>

<style>

</style>
