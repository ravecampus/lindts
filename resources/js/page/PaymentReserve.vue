<template>
<div class="container py-5 m-top">
    <!-- For demo purpose -->
    <div class="row mb-4">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-6">Payment Form</h1>
        </div>
    </div> <!-- End -->
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="card ">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2 text-center">
                        <h4>Paypal</h4>
                    </div>
                    <!-- Paypal info -->
                    <div id="paypal" class="pt-3" v-if="reserve.id != undefined" >
                        <h6 class="pb-2">Reservation #: {{ reserve.reservation_number}}</h6>
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Name / MObile # : <strong>{{ reserve.full_name }} / {{ reserve.mobile_number}} </strong>
                             </label> 
                        </div>
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Amount : <strong>&#8369; {{ formatAmount(reserve.total) }}</strong>
                             </label> 
                        </div>
                        <!-- <div class="form-group "> 
                             <label class="radio-inline"> 
                                Delivery Fee : <strong>&#8369; {{ formatAmount(reserve.delivery_fee) }}</strong>
                             </label>
                        </div> -->
                        <!-- <div class="form-group "> 
                             <label class="radio-inline"> 
                                Total Amount :  <strong>&#8369; {{ formatAmount(reserve.grand_total) }}</strong>
                             </label>
                        </div> -->
                        <p> <button v-if="reserve.id != undefined" type="button" @click="payByPaypal" class="book-a-table-btn "><i class="fab fa-paypal mr-2"></i>{{ btn_cap }}</button> </p>
                        <hr>
                        <p class="text-muted"> Note: After clicking on the button, you will be directed to a secure gateway for payment. After completing the payment process, you will be redirected back to the website to view details of your order. </p>
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
            post:{},
            btn_cap:'Log into my Paypal'
        }
    },
    methods: {

        payByPaypal(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btn_cap = "Proccessing..."
                this.btndis = true;
                this.post = this.reserve;
                this.$axios.post('api/payreserve', this.post).then(res=>{
                    this.btn_cap = "Log into my Paypal"
                    this.btndis = false;
                    window.location.href = res.data;
                });
            });
        },
        getReserveByPayment(id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/reserve-payment',{params:{'reservation_number':id}}).then(res=>{
                    this.reserve = res.data;
                });
            });
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    },
    mounted() {
        let id = this.$route.query.reserve;
        this.getReserveByPayment(id);
    },
}
</script>

<style>

</style>
