<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Orders</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Order # ..." @input="listOfOrder()">
                            </div>
                          
                            <button class="au-btn-filter mr-1" type="button" @click="filterOrder(1)">
                                <i class="zmdi zmdi-filter-list"></i>Delivery
                            </button>
                            <button class="au-btn-filter mr-1" type="button" @click="filterOrder(2)">
                                <i class="zmdi zmdi-filter-list"></i>Walkin
                            </button>
                              <button class="au-btn-filter " type="button" @click="filterOrder(3)">
                                <i class="zmdi zmdi-filter-list"></i> Served
                            </button>
                        </div>
                        <div class="table-data__tool-right">
                            <div class="col-lg-12 text-center mt-2">
                                <h4> {{ tableData.filter == 0 ? "All" : tableData.filter == 1 ? " Delivery": tableData.filter == 2 ? "Walkin" : "Served" }}</h4>
                            </div>
                            <!-- <button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" @click="showProductModal">
                                <i class="zmdi zmdi-plus"></i>add Product</button> -->
                            <!-- <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2" name="type">
                                    <option selected="selected">All</option>
                                    <option value="">Delivery</option>
                                    <option value="">Walkin</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div> -->
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in orders" :key="idx">
                            <tr class="tr-shadow">
                                <td>
                                    <strong>{{ list.order_number }}</strong>
                                </td>
                                <td>
                                    <span class="status--process">{{ list.full_name }}</span>
                                </td>
                                <td >
                                    <div class="badge badge-primary text-white">{{  list.order_items.length }} item/s</div>
                                    <li class="card card-body p-1 m-1 shadow-sm" v-for="(ls, idx)  in list.order_items" :key="idx">
                                        {{ ls.name }}...{{ formatAmount(ls.price) }} x {{ ls.quantity }}
                                    </li>
                                    <div class="mt-3">
                                        <button v-if="list.status == 1 && list.payment_mode == 1" @click="saveStatusDelivery(list, 2)" class="btn btn-sm btn-warning btn-block" data-toggle="tooltip" data-placement="top"  title="Setting status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                             set on Prepare to Kitchen
                                        </button>
                                        <button v-if="list.status == 2 && list.payment_mode == 1" @click="saveStatusDelivery(list, 3)" class="btn btn-sm btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="Setting Status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                             set on for Delivery
                                        </button>
                                        <button  v-if="list.status == 0 && list.payment_mode == 2" @click="saveStatusWalkin(list, 1)" class="btn btn-sm btn-danger btn-block" data-toggle="tooltip" data-placement="top" title="Setting Status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                             set on Prepare to Kitchen
                                        </button>
                                         <button  v-if="list.status == 1 && list.payment_mode == 2" @click="saveStatusWalkin(list, 2)" class="btn btn-sm btn-success btn-block" data-toggle="tooltip" data-placement="top" title="Setting Status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            set on Ready to Pickup
                                        </button>
                                    </div>
                                </td>
                                <td class="desc">{{ list.delivery_address }}</td>
                                <td>
                                    <span>{{ formatAmount(list.total) }}</span>
                                </td>
                                <td>
                                    <span>{{ formatAmount(list.delivery_fee) }}</span>
                                </td>
                                <td>
                                    <span>{{ formatAmount(list.grand_total) }}</span>
                                </td>
                                 <td>
                                    <span class="text-danger">{{ setStatus(list) }}</span>
                                </td>
                                <td>
                                    <span>{{formatDate(list.created_at) }}</span>
                                </td>
                            
                            </tr>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </data-table>
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listOfOrder(pagination.prevPageUrl)"
                            @next="listOfOrder(pagination.nextPageUrl)"
                            v-show="noData(orders)">
                        </pagination>
                    </div>
                    <div class="card" v-show="!noData(orders)">
                        <div class="card-body">
                            <div class="text-center">No Orders Found!</div>
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div> 
            </div>
        </div>
    </div>
     <div class="modal fade" id="product" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Code</label>
                            <input class="au-input au-input--full" type="text" v-model="post.code"  placeholder="Code">
                            <span class="errors-material" v-if="errors.code">{{errors.code[0]}}</span>
                            
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input class="au-input au-input--full" type="text"  v-model="post.name"  placeholder="Name">
                            <span class="errors-material" v-if="errors.name">{{errors.name[0]}}</span>

                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input class="au-input au-input--full" type="text"  v-model="post.description"  placeholder="Description">
                            <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>
                        </div>
                        <div class="form-group">
                            <label for="select" class=" form-control-label">Food Category</label>
                            <select name="select" id="select" v-model="post.food_category_id" class="form-control">
                                <option v-for="(lst, idx) in categories" :key="idx" :value="lst.id">{{ lst.category_name}}</option>
                               
                            </select>
                            <span class="errors-material" v-if="errors.food_category_id">{{errors.food_category_id[0]}}</span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input class="au-input au-input--full" type="number"  v-model="post.price"  placeholder="Price">
                            <span class="errors-material" v-if="errors.price">{{errors.price[0]}}</span>
                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                    <button type="button" class="btn btn-primary" @click="saveProduct">Save</button>
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade" id="upload-img" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Product Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="logo-view text-center">
                                <img :src="upload.image == null ? '../images/icon/icon.png' :'../storage/products/'+upload.image">
                                <!-- <a href="#" @click="resetLogo()">Reset Default</a> -->
                            </div>
                        </div>
                        <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" @click="browseImg()" class="btn btn-success mt-3">Browse Image</button>
                </div>
                
            </div>
        </div>
    </div>
</div>
</template>

<script>
import DataTable from '../table/DataTable'
import PaginationVue from '../table/Pagination';

export default {
    components:{
        dataTable:DataTable,
        pagination:PaginationVue
    },

    data() {
        let sortOrders = {};
        let columns =[
        {label:'Order #', name:'order_number'},
        {label:'Full name', name:'full_name'},
        {label:'Orders', name:null},
        {label:'Delivery Address', name:'delivery_address'},
        {label:'Total', name:null},
        {label:'Delivery Fee', name:null},
        {label:'Grand Total', name:null},
        {label:'Status', name:null},
        {label:'Date', name:'created_at'},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return {
            orders:[],
            categories:[],
            post:{},
            errors:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
            upload:{},
            img:'',
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                archive:0,
                dir:'desc',
                filter:1,
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
            form: new FormData,
            uploadPercentage_:0,
            showbar:false,
        }
    },
    methods: {
        showProductModal(){
            $('#product').modal('show');
        },

        editProductModal(data){
            this.post = data;
            $('#product').modal('show');
        },
        listOfOrder(urls='api/order'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.orders = data.data.data;
                        this.configPagination(data.data);
                    }else{
                        this.not_found = true;
                    }
                
                }).catch(err=>{
                
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
                this.listOfOrder();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        listCategory(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/list-category').then(res=>{
                    this.categories = res.data;
                });
            });
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        filterOrder(num){
            this.tableData.filter = num;
            this.listOfOrder();
        },
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        payMode(data){
            return data == 1 ? "Delivery" : "Walkin";
        },
        setStatus(data){
            let mode = data.payment_mode;
            let status = data.status;
            if(mode == 1){
                return ( status == 0 ? "Unpaid" : status == 1 ? "Paid and Received" : status == 2 ? " Kitchen" : status == 3 ? "In Transit" :  status == 4 ? "Delivered" : "Canceled") +" (Delivery)";
            }else{
                return ( status == 0 ? "Received" : status == 1 ? "Kitchen" : status == 2 ? "Ready to Pickup" :status == 4 ? "Picked" : "Canceled") + " (Walkin)";
            }
        },

        saveStatusDelivery(data, num){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/set-status', {'status':num,'id':data.id})
                    .then(response => {
                      if(num == 2){
                          this.$emit('show',{'message':'Status Mode is set on the KITCHEN!', 'status':4});
                      }else if(num == 3){
                          this.$emit('show',{'message':'Status Mode is set on the IN TRANSIT!', 'status':4});
                      }
                      this.listOfOrder();
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        saveStatusWalkin(data, num){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/set-status',{'status':num,'id':data.id})
                    .then(response => {
                      if(num == 1){
                          this.$emit('show',{'message':'Status Mode is set on the KITCHEN!', 'status':4});
                      }else if(num == 2){
                          this.$emit('show',{'message':'Status Mode is set on the READY TO PICKUP!', 'status':4});
                      }
                      this.listOfOrder();
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
                    
            })
        }
       
    },
    mounted() {
        this.listOfOrder();
        this.listCategory()
    },
}
</script>

<style>

</style>
