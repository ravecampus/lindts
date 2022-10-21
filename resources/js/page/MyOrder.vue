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
              <input type="text" v-model="dataset.search" @input="listOfProductWithFilter(0)" class="form-control" placeholder="Search...">
          </div>
          <div class="col-lg-12 d-flex justify-content-center">
            <ul id="menu-flters">
              <li @click="listOfOrderAuth(1)">Delivery</li>
              <li  @click="listOfOrderAuth(2)">Walkin</li>
              <li  @click="listOfOrderAuth(0)">History</li>
            
            </ul>
          </div>
        </div>

        <div class="row menu-container d-flex justify-content-center mt-5">
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
                                    <button type="button" class="btn btn-warning btn-sm">View items
                                        <i class="badge badge-success">{{ list.order_items.length }}</i>
                                    </button>
                                    <!-- <span>{{list.order_items }}</span> -->
                                </td>
                                <td>
                                    <span>{{list.status }}</span>
                                </td>
                                <td>
                                    <span>{{formatDate(list.created_at) }}</span>
                                </td>
                                <td>
                                    <div class="table-data-feature">
                                        <!-- <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                            <i class="zmdi zmdi-mail-send"></i>
                                        </button> -->
                                        <button class="item" data-toggle="tooltip" data-placement="top"  @click="editProductModal(list)" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                        <!-- <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                            <i class="zmdi zmdi-more"></i>
                                        </button> -->
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

    <div class="modal fade order-menu" ref="ordermenu" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Menu to Tray</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="menu-img-lg">
                               <img :src="post.image == null ? '../images/icon/icon.png' :'../storage/products/'+post.image" class="m-img" alt="">
                                <!-- <a href="#" @click="resetLogo()">Reset Default</a> -->
                                
                            </div>
                            <div class="text-center mt-2">
                                <div class="menu-content mt-0">
                                <strong>{{post.name}} </strong> (<span>&#8369;{{formatAmount(post.price)}}</span>)
                                </div>
                                <div class="menu-ingredients">
                                {{post.description}}
                                </div>
                                <div v-if="menu.total > 0" class="mt-4">
                                     Total: <span class="badge badge-secondary">&#8369; {{ formatAmount(menu.total) }}</span>
                                </div>
                            </div>
                        </div>
                        <input type="file" id="uploader" accept="image/gif, image/jpeg" @change="uploadImage" class="hidden">
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <div class="row">
                        <div class="col-md-5">
                          
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <strong>Qty. &nbsp;</strong>
                                    <button class="btn btn-secondary btn-sm" @click="minusQty(menu)">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" readonly v-model="menu.qty"  placeholder="Qty" class="form-control form-control-sm">
                                <div class="input-group-btn">
                                    <button class="btn btn-secondary btn-sm" @click="addQty(menu)">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <button type="button" @click="AddToTray()" :disabled="btndis" class="book-a-table-btn pull-right">Add to Tray</button>
                        </div>
                    </div>
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
        
            menu:{},
            product:{},
            dataset:{
                search:''
            },
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

    }
}
</script>

<style>

</style>
