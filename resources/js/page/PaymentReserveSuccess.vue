<template>
<div class="container py-5 m-top">
    <!-- For demo purpose -->
    <!-- <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">RECEIPT</h1>
        </div>
    </div> -->
     <!-- End -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card" v-if="checkPayment(reserve)" >
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2 text-center">
                        <h4>{{ this.title }} Reservation</h4>
                    </div>
                    <!-- Paypal info -->
                    <div id="paypal" class="pt-3">
                        <h6 class="pb-2">Reservation #: {{ reserve.reservation_number }}</h6>
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Name / Mobile # : <strong>{{ reserve.full_name }} / {{ reserve.mobile_number}} </strong>
                             </label> 
                        </div>
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Amount : <strong>&#8369; {{ formatAmount(reserve.total) }}</strong>
                             </label> 
                        </div>
                        <div class="form-group "> 
                             <label class="radio-inline"> 
                                Payment ID : <strong>{{ payment.payment_id }}</strong>
                             </label>
                        </div>
                        <div class="form-group "> 
                             <label class="radio-inline"> 
                                Payer Email :  <strong>{{ payment.payer_email }}</strong>
                             </label>
                        </div>
                        <p> <button type="button" @click="printReceipt()" class="book-a-table-btn d-print-none"><i class="fa fa-print mr-2"></i>Print</button> </p>
                        <!-- <p class="text-muted"> Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order. </p> -->
                    </div> <!-- End -->
                 
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            reserve:{},
            message:"",
            data:" ",
            payment:{},
            title:  ""
        }
    },
    methods: {
        setPaymentSuccess(query){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.message = "Processing ...";
                this.$axios.get('api/payreserve-success', {params:query}).then(res=>{
                //    this.$router.push({name:'toship'});
                    // console.log(res.data)
                    this.message = " ";
                    this.reserve = res.data.reserve;
                    this.payment = res.data.payment;
                });
            });
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        checkPayment(data){
            console.log(data)
            let ret = false;
            if(data != null){
                ret = true
               
            }else{
                this.$router.push({name:'dashboard'});
            }
            return ret;
        },
        printReceipt(){
            window.print();
        }
    },
    mounted() {
        let query = this.$route.query;
        this.setPaymentSuccess(query)
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
