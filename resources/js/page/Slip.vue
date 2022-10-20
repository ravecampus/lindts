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
            <div class="card" v-if="order.id != undefined">
                <div class="card-header">
                    <div class="bg-white shadow-sm pt-4 pl-2 pr-2 pb-2 text-center">
                        <h4>{{ this.title }}</h4>
                    </div>
                    <!-- Paypal info -->
                    <div id="paypal" class="pt-3">
                        <h6 class="pb-2">Order #: {{ order.order_number }}</h6>
                        <hr class="my-2">
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Name / Address : <strong>{{ order.full_name }} / {{ order.delivery_address}} </strong>
                             </label> 
                        </div>
                        <div class="form-group "> 
                             <label class="radio-inline">
                                 Total : <strong>&#8369; {{ formatAmount(order.total) }}</strong>
                             </label> 
                        </div>
                       
                        <div class="form-group "> 
                            <label class="radio-inline">
                                Grand Total : <strong>&#8369; {{ formatAmount(order.grand_total) }}</strong>
                             </label> 
                        </div>
                        <hr class="my-2">
                         <div class="form-group "> 
                            <label class="radio-inline">
                              Order Slip
                             </label> 
                             <p class="small"> Serve as reference for your Orders Or give your Order Number and your complete name!</p>
                        </div>
                        <hr class="my-4">
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
            order:{},
            message:"",
            data:" ",
            payment:{},
            title:  ""
        }
    },
    methods: {
        getOrderByPayment(id){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/order-payment',{params:{'order_number':id}}).then(res=>{
                    this.order = res.data;
                });
            });
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        printReceipt(){
            window.print();
        }
    },
    mounted() {
        let id = this.$route.query.order;
        this.getOrderByPayment(id);
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
