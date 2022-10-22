<template>
    <!-- ======= Menu Section ======= -->
    <main id="main">
    <section id="menu" class="menu m-top">
      <div class="container">

        <div class="section-title">
          <h2 class="title-design">My Orders <span></span></h2>
        </div>
        
        <div class="row">
          <div class="col-lg-12 mb-3">
              <input type="text" v-model="tableData.search" @input="listOfOrderAuth()" class="form-control" placeholder="Search...">
          </div>
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="menu-flters">
              <li @click="filterOrder(0)">All</li>
              <li @click="filterOrder(1)">Delivery</li>
              <li  @click="filterOrder(2)">Walkin</li>
              <li  @click="filterOrder(3)">Canceled</li>
              <li  @click="filterOrder(4)">History</li>
            
            </ul>
          </div>
          <hr>
          <div class="col-lg-12 text-center mt-2">
             <h4> {{ tableData.filter == 0 ? "All" : tableData.filter == 1 ? " Delivery": tableData.filter == 2 ? "Walkin" :tableData.filter == 3 ? "Canceled": "History" }}</h4>
          </div>
        </div>

        <div class="row menu-container d-flex justify-content-center mt-2">
          <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in orders" :key="idx">
                            <tr class="tr-shadow">
                                <td>{{ list.order_number }}
                                    <!-- <img class="img-thumbnail w-50" :src="list.image == null ? '../images/icon/icon.png' :'../storage/products/'+list.image" />
                                    <div class="">
                                        <a href="#" @click="showUpload(list)" >Edit </a>
                                    </div> -->
                                </td>
                                <td><span class="status--process">&#8369;{{ formatAmount(list.total) }}</span></td>
                                <td class="desc">&#8369; {{ list.payment_mode == 1 ? formatAmount(list.delivery_fee) : 0 }}</td>
                                <td>
                                    <span>&#8369; {{ formatAmount(list.grand_total) }}</span>
                                </td>
                                <td>
                                    <button type="button" @click="orderItem(list.order_items)" class="btn btn-warning btn-sm">View items
                                        <i class="badge badge-success">{{ list.order_items.length }}</i>
                                    </button>
                                    <!-- <span>{{list.order_items }}</span> -->
                                </td>
                                <td>
                                    <span class="text-danger">{{ setStatus(list) }}</span>
                                </td>
                                <td>
                                    <span>{{formatDate(list.created_at) }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" v-if="list.status == 0 && list.payment_mode == 1">
                                        <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"  @click="payOrder(list)" title="Pay with Paypal">
                                            Pay
                                        </button>
                                        <button class="btn btn-sm btn-secondary" @click="showCancelOrder(list)" data-toggle="tooltip" data-placement="top" title="Cancel Orders">
                                            Cancel
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </data-table>
                    <div class="col-md-12">
                        <div class="pull-right">
                            <pagination :pagination="pagination"
                                @prev="listOfOrderAuth(pagination.prevPageUrl)"
                                @next="listOfOrderAuth(pagination.nextPageUrl)"
                                v-show="noData(orders)">
                            </pagination>
                        </div>
                        
                    </div>

        </div>
        <div class="card" v-show="!noData(orders)">
            <div class="card-body">
                <div class="text-center">No Orders Found!</div>
            </div>
        </div>

      </div>
    </section><!-- End Menu Section -->

    <div class="modal fade order-items" ref="ordermenu" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Menu</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive card">
                                <table class="table table-sm card-body">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ls, idx) in items" :key="idx">
                                            <td>
                                            <div class="image-responsive img-myorder">
                                                <img :src="ls.image == null ? '../images/icon/icon.png' :'../storage/products/'+ls.image" class="m-img" alt="">
                                                
                                            </div>
                                            </td>
                                            <td>{{ ls.code }}</td>
                                            <td>{{ ls.name }}</td>
                                            <td>{{ ls.quantity }}</td>
                                            <td>{{ formatAmount(ls.price) }}</td>
                                            <td>{{ formatAmount(ls.price  * ls.quantity) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade cancel-order" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="modal-header">
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-warning">Do you want to cancel your Orders?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" @click="cancelOrder(canda)" class="btn btn-warning btn-sm">Yes</button>
                    <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button>
                </div>
            </div>
        </div>
    </div>
    
    </main>
</template>

<script>
import DataTable from '../table/DataTable'
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },
    data(){
        let sortOrders = {};
        let columns =[
        {label:'Order Number', name:'order_number'},
        {label:'Total', name:'total'},
        {label:'Delivery Fee', name:'delivery_fee'},
        {label:'Grand Total', name:'Grand Total'},
        {label:'Items', name:null},
        {label:'Status', name:'status'},
        {label:'Order Date', name:'created_at'},
        {label:' ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            orders:[],
            categories:[],
            products:[],
            post:{
                qty:0
            },
            items:{},
            menu:{},
            product:{},
            dataset:{
                search:''
            },
            canda:{},
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            btndis: false,
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:0,
            },
            pagination:{
                lastPage:'',
                currentPage:'',
                total:'',
                lastPageUrl:'',
                nextPageurl:'',
                prevPageUrl:'',
                from:'',
                to:''
            },
            
        }
    },
    mounted() {
        this.listOfOrderAuth();
         $(this.$refs.ordermenu).on('hidden.bs.modal',()=> {
            this.menu.qty = 1;
            let tt = this.post.price * this.menu.qty;
            this.menu.total = tt;
            this.trays = [];
        });
        
    },

    methods:{
        //  listCategory(){
        //     this.$axios.get('sanctum/csrf-cookie').then(response=>{
        //         this.$axios.get('api/list-category').then(res=>{
        //             this.categories = res.data;
        //         });
        //     });
        // },

        listOfOrderAuth(url='api/order-auth'){
             
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.orders = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                });
            });
        },
        configPagination(data){
            this.pagination.lastPage = data.last_page;
            this.pagination.currentPage = data.current_page;
            this.pagination.total = data.total;
            this.pagination.lastPageUrl = data.last_page_url;
            this.pagination.nextPageUrl = data.next_page_url;
            this.pagination.prevPageUrl = data.prev_page_url;
            this.pagination.from = data.from;
            this.pagination.to = data.to;
        },
        sortBy(key){
            if(key != null){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
                this.tableData.column = this.getIndex(this.columns, 'name', key);
                this.tableData.dir = this.sortOrders[key] === 1 ? 'asc' : 'desc';
                this.listOfOrderAuth();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        orderItem(data){
            this.items = data;
            $('.order-items').modal('show');
        },
        filterOrder(num){
            this.tableData.filter = num;
            this.listOfOrderAuth();
        },
        payOrder(data){
            this.$router.push({name:'payment', query:{'order':data.order_number}});
        },
        setStatus(data){
            let mode = data.payment_mode;
            let status = data.status;
            if(mode == 1){
                return ( status == 0 ? "Unpaid" : status == 1 ? "Paid and Received" : status == 2 ? " Kitchen" : status == 3 ? "In Transit" :  status == 4 ? "Delivered" : "Cancel") +" (Delivery)";
            }else{
                return ( status == 0 ? "Received" : status == 1 ? "Kitchen" : status == 2 ? "Ready to Pickup" :status == 4 ? "Picked" : "Cancel") + " (Walkin)";
            }
        },
        showCancelOrder(data){
            this.canda = data;
            $('.cancel-order').modal('show');
        },
        cancelOrder(data){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/set-status', {'status':5,'id':data.id})
                    .then(response => {
                        this.listOfOrderAuth();
                        $('.cancel-order').modal('hide');
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        cancelButton(){
             $('.cancel-order').modal('hide');
        }

    }
}
</script>

<style>

</style>
