<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Reservations</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Reservation # ..." @input="listOfReserve()">
                            </div>
                          
                            <button class="au-btn-filter mr-1" type="button" @click="filterOrder(1)">
                                <i class="zmdi zmdi-filter-list"></i>Booked
                            </button>
                            <!-- <button class="au-btn-filter mr-1" type="button" @click="filterOrder(2)">
                                <i class="zmdi zmdi-filter-list"></i>Walkin
                            </button> -->
                              <button class="au-btn-filter " type="button" @click="filterOrder(2)">
                                <i class="zmdi zmdi-filter-list"></i> Served
                            </button>
                        </div>
                        <div class="table-data__tool-right">
                            <div class="col-lg-12 text-center mt-2">
                                <h4> {{ tableData.filter == 1 ? " Booked": tableData.filter == 2 ? "Served" : "" }}</h4>
                            </div>
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in reserves" :key="idx">
                            <tr class="tr-shadow">
                                <td>
                                   <span> <strong>{{ list.reservation_number }}</strong></span>
                                </td>
                                <td>
                                    <span class="status--process">{{ list.full_name }}</span>
                                </td>
                                <td >
                                    <div class="badge badge-primary text-white">{{  list.reserves.length }} item/s</div>
                                    <li class="card card-body p-1 m-1" v-for="(ls, idx)  in list.reserves" :key="idx">
                                        {{ ls.name }}...{{ formatAmount(ls.price) }} x {{ ls.quantity }}
                                    </li>
                                    <div class="mt-3">
                                        <button v-if="list.status == 1" @click="saveStatusApproved(list, 2)" class="btn btn-sm btn-primary btn-block" data-toggle="tooltip" data-placement="top"  title="Setting status">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                             set on Approved
                                        </button>
                                    </div>
                                </td>
                                <td class="desc">{{ list.mobile_number }}</td>
                                <td>
                                    <span>{{ formatAmount(list.total) }}</span>
                                </td>
                                <!-- <td>
                                    <span>{{ formatAmount(list.delivery_fee) }}</span>
                                </td>
                                <td>
                                    <span>{{ formatAmount(list.grand_total) }}</span>
                                </td> -->
                                 <td>
                                    <span class="text-danger">{{ setStatus(list.status) }}</span>
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
                            @prev="listOfReserve(pagination.prevPageUrl)"
                            @next="listOfReserve(pagination.nextPageUrl)"
                            v-show="noData(reserves)">
                        </pagination>
                    </div>
                    <div class="card" v-show="!noData(reserves)">
                        <div class="card-body">
                            <div class="text-center">No Reservations Found!</div>
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
        {label:'Reservation #', name:'reservation_number'},
        {label:'Full name', name:'full_name'},
        {label:'Orders', name:null},
        {label:'Mobile #', name:null},
        {label:'Total', name:null},
        // {label:'Delivery Fee', name:null},
        // {label:'Grand Total', name:null},
        {label:'Status', name:null},
        {label:'Date', name:'created_at'},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return {
            reserves:[],
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
            }
        }
    },
    methods: {
        listOfReserve(urls='api/reserve-list'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.reserves = data.data.data;
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
                this.listOfReserve();
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
            this.listOfReserve();
        },
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        payMode(data){
            return data == 1 ? "Delivery" : "Walkin";
        },
        setStatus(num){
            return num == 0 ? "Received" : num == 1 ? "Confirmed" :  num == 2 ? "Approved" :num == 3? "Served" :"Canceled";
        },
        saveStatusApproved(data, num){
             this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/reserve-status', {'status':num,'id':data.id})
                .then(response => {
                    this.$emit('show',{'message':'Status Mode is set on the APPROVED!', 'status':4});
                    this.listOfReserve();
                })
                .catch(function (error) {
                    
                });
            })
        },
       
    },
    mounted() {
        this.listOfReserve();
        this.listCategory()
    },
}
</script>

<style>

</style>
