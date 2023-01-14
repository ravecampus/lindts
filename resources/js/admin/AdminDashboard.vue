<template>
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">


            <section class="statistic">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-lg-3" v-if="obj.user != undefined">
                                <div class="statistic__item">
                                    <h2 class="number">{{ formatAmount(obj.user) }}</h2>
                                    <span class="desc">Customers</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-account-o"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3" v-if="obj.item_sold != undefined">
                                <div class="statistic__item">
                                    <h2 class="number">{{ formatAmount(obj.item_sold) }}</h2>
                                    <span class="desc">items sold</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-shopping-cart"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3" v-if="obj.products != undefined">
                                <div class="statistic__item">
                                    <h2 class="number">{{ formatAmount(obj.products) }}</h2>
                                    <span class="desc">products</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-calendar-note"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3" v-if="obj.sales != undefined">
                                <div class="statistic__item">
                                    <h2 class="number">&#8369;{{ formatAmount(obj.sales) }}</h2>
                                    <span class="desc">sales order</span>
                                    <div class="icon">
                                        <i class="zmdi zmdi-money"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return{
            obj:{}
        }
    },
    methods: {
        loadDashboard(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/dashboard').then(res=>{
                    this.obj = res.data;
                });
            });
        },
        formatAmount(num){
            let val = (num/1).toFixed(0).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
    },
    mounted() {
        this.loadDashboard();
    },
}
</script>

<style>

</style>
