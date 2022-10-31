<template>
    <div class="container py-5 m-top">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h6 class="text-white">Book your Orders</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small mb-1" >Full Name</label>
                            <input class="form-control" v-model="post.full_name" type="text" placeholder="Full name">
                            <span class="errors-material" v-if="errors.full_name">{{errors.full_name[0]}}</span>
                        </div>
                         <div class="mb-3">
                            <label class="small mb-1" >Mobile Number</label>
                            <input class="form-control" v-model="post.mobile_number" type="text" placeholder="Mobile Number">
                            <span class="errors-material" v-if="errors.mobile_number">{{errors.mobile_number[0]}}</span>
                        </div>
                       
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                 <div class="card">
                     <div class="card-header bg-secondary">
                        <h6 class="text-white">Menu</h6>
                     </div>
                     <div class="card-body">
                        <!-- <div> -->
                            <!-- <div class="row"> -->
                                <div class="form-group">
                                    <label class="small" >Number Of Person</label>
                                    <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Number of Person">
                                    <span class="errors-material" v-if="errors.number_of_person">{{errors.number_of_person[0]}}</span>
                                </div>
                                <div  class="form-group">
                                    <label class="small" >Reservation Date</label>
                                    <!-- <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Reservation Date"> -->
                                    <Datepicker v-model="post.reservation_date" placeholder="Reservation Date" :format="format"/>
                                    <span class="errors-material" v-if="errors.reservation_date">{{errors.reservation_date[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label class="small" >Reservation Time</label>
                                     <Datepicker v-model="post.reservation_time" timePicker placeholder="Reservation Time" />
                                    <!-- <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Reservation Time"> -->
                                    <span class="errors-material" v-if="errors.reservation_time">{{errors.reservation_time[0]}}</span>
                                </div>
                            <!-- </div> -->
                            <hr>
                            <div class="row">
                                <div>
                                    <label class="small mb-1" >Select our </label>
                                    <button type="button" @click="showMenu()" class="book-a-table-btn btn-sm-table"><span class="fa fa-plus"></span> Menu</button>
                                    <div class="btn-group pull-right">
                                        <button type="button" @click="saveReservation()" class="book-a-table-btn btn-sm-table"><span class="fa fa-send"></span> {{ btncap }}</button>
                                        <button type="button" @click="showBooking()" class="book-a-table-btn btn-sm-table"><span class="fa fa-list"></span> List of Booking</button>
                                        <button type="button" @click="showHistory()" class="book-a-table-btn btn-sm-table"><span class="fa fa-list"></span> History & Canceled</button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="errors.menu" ><span class="errors-material" >{{errors.menu[0]}}</span></div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="list-group">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(list, idx) in reserves" :key="idx">
                                                    <td><strong>{{ list.name }}</strong></td>
                                                    <td>{{ formatAmount(list.price) }}</td>
                                                    <td>
                                                        <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                            <button class="btn btn-link px-2 btn-qty"
                                                            @click="minusQty(list)" >
                                                                <i class="fas fa-minus"></i>
                                                            </button>

                                                            <input id="form1" readonly min="0" name="quantity" :value="list.quantity" type="number"
                                                                class="form-control form-control-sm form-wt" />

                                                            <button class="btn btn-link px-2 btn-qty"
                                                                @click="addQty(list)" >
                                                                <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        
                                                    </td>
                                                    <td>{{ formatAmount(list.total) }}</td>
                                                    <td>
                                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                            <a href="#!" @click="removeFromTray(list.product_id)" class="text-muted btn-qty"><i class="fas fa-times"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3">
                                                        <div class="text-right">TOTAL :</div>
                                                    </td>
                                                    <td colspan="2"><strong>{{ formatAmount(grandTotal(reserves)) }}</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </ul>
                                </div>
                            </div>
                        </div>
                     </div>
                 <!-- </div> -->
            </div>
        </div>

        <div class="modal fade menu-list" ref="menulist">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Menu</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <input type="text" v-model="dataset.search" @input="listOfProductWithFilter(0)" class="form-control" placeholder="Search...">
                            </div>
                            <div class="col-lg-12 d-flex justify-content-center mb-3">
                                <!-- <ul id="menu-flters"> -->
                                <button type="button" class="btn btn-warning btn-sm text-white ml-1" @click="listOfProductWithFilter(0)">Show All</button>
                                <button  type="button" class="btn btn-warning btn-sm text-white ml-1" v-for="(list, index) in categories" :key="index"   @click="listOfProductWithFilter(list.id)">{{ list.category_name }}</button>
                                
                                <!-- </ul> -->
                            </div>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-12 mb-5">
                                <input type="text" class="form-control" placeholder="Search...">
                            </div> -->
                            <div class="col-md-12">
                                <div class="table-responsive card">
                                    <table class="table table-sm card-body table-stripe">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Code</th>
                                                <th>Description</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(ls, idx) in products" :key="idx">
                                                <td>
                                                <div class="image-responsive img-myorder">
                                                    <img :src="ls.image == null ? '../images/icon/icon.png' :'../storage/products/'+ls.image" class="m-img" alt="">
                                                </div>
                                                </td>
                                                <td>{{ ls.code }}</td>
                                                <td>{{ ls.name }}</td>
                                                <td>{{ formatAmount(ls.price) }}</td>
                                                <td>
                                                    <button type="button" @click="addReserve(ls)" class="btn btn-sm btn-success"><span class="fa fa-plus"></span></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="card m-2" v-show="!noData(products)">
                                        <div class="card-body">
                                            <div class="text-center">No Menu Found!</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <div class="row">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
            <div class="modal fade booking" ref="booking">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reservation List</h5>
                        </div>
                        <div class="modal-body">
                            
                        <div class="row menu-container d-flex justify-content-center mt-2">
                            <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                <tbody v-for="(list, idx) in bookings" :key="idx">
                                        <tr class="tr-shadow">
                                            <td>
                                                {{ list.reservation_number }}
                                            </td>
                                            <td>
                                                <div class="small" >
                                                    <li v-for="(ls,idx_) in list.reserves" :key="idx_">
                                                        {{ ls.name }} (&#8369;{{ formatAmount(ls.price) }} x {{ ls.quantity }}),
                                                    </li>
                                                </div>
                                            </td>

                                            <td><span class="status--process">&#8369;{{ formatAmount(list.total) }}</span></td>
                                            <td class="desc">{{ list.number_of_person }}</td>
                                            <td>
                                                <span>{{ formatDate(list.reservation_date) }}</span>
                                            </td>
                                            <td>
                                                <span>{{ list.reservation_time }}</span>
                                                <!-- <span>{{list.order_items }}</span> -->
                                            </td>
                                            <td>
                                                <span class="text-danger">{{ setStatus(list.status) }}</span>
                                            </td>
                                            <td>
                                                <span>{{formatDate(list.created_at) }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group" v-if="list.status == 0">
                                                    <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"  @click="payReserve(list)" title="Pay with Paypal">
                                                        Pay
                                                    </button>
                                                    <button class="btn btn-sm btn-secondary" @click="showCancelReserve(list)" data-toggle="tooltip" data-placement="top" title="Cancel Orders">
                                                        Cancel
                                                    </button>
                                                </div>
                                                <button v-if="list.status == 2" class="btn btn-sm btn-primary" @click="finished(list)" data-toggle="tooltip" data-placement="top" title="Cancel Orders">
                                                        Finished
                                                </button>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                        
                                    </tbody>
                                </data-table>
                                <div class="col-md-12">
                                    <div class="pull-right">
                                        <pagination :pagination="pagination"
                                            @prev="listOfBookings(pagination.prevPageUrl)"
                                            @next="listOfBookings(pagination.nextPageUrl)"
                                            v-show="noData(bookings)">
                                        </pagination>
                                    </div>
                                </div>
                            </div>
                <div class="card" v-show="!noData(bookings)">
                    <div class="card-body">
                        <div class="text-center">No Reservation Found!</div>
                    </div>
                </div>


                </div>
                <div class="modal-footer text-center">
                    <div class="row">
                    </div>
                </div>
            </div>
            </div>
            </div>

            <div class="modal fade history" ref="history">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">History & Canceled</h5>
                        </div>
                        <div class="modal-body">
                            
                            <div class="row menu-container d-flex justify-content-center mt-2">
                                <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                                    <tbody v-for="(list, idx) in bookings" :key="idx">
                                            <tr class="tr-shadow">
                                                <td>
                                                    {{ list.reservation_number }}
                                                </td>
                                                <td>
                                                    <div class="small" >
                                                        <li v-for="(ls,idx_) in list.reserves" :key="idx_">
                                                            {{ ls.name }} (&#8369;{{ formatAmount(ls.price) }} x {{ ls.quantity }}),
                                                        </li>
                                                    </div>
                                                </td>

                                                <td><span class="status--process">&#8369;{{ formatAmount(list.total) }}</span></td>
                                                <td class="desc">{{ list.number_of_person }}</td>
                                                <td>
                                                    <span>{{ formatDate(list.reservation_date) }}</span>
                                                </td>
                                                <td>
                                                    <span>{{ list.reservation_time }}</span>
                                                    <!-- <span>{{list.order_items }}</span> -->
                                                </td>
                                                <td>
                                                    <span class="text-danger">{{ setStatus(list.status) }}</span>
                                                </td>
                                                <td>
                                                    <span>{{formatDate(list.created_at) }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" v-if="list.status == 0">
                                                        <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top"  @click="payReserve(list)" title="Pay with Paypal">
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
                                                @prev="listOfBookings(pagination.prevPageUrl)"
                                                @next="listOfBookings(pagination.nextPageUrl)"
                                                v-show="noData(bookings)">
                                            </pagination>
                                        </div>
                                    </div>
                                </div>
                            <div class="card" v-show="!noData(bookings)">
                        <div class="card-body">
                            <div class="text-center">No Reservation Found!</div>
                        </div>
                    </div>
                </div>
                        <div class="modal-footer text-center">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <div class="modal fade cancel-reserve" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    </div>
                    <div class="modal-body bg-light">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="text-warning">Do you want to cancel your Reservation?</h4>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-center">
                        <button type="button" @click="cancelReserve(canda)" class="btn btn-warning btn-sm">Yes</button>
                        <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

import DataTable from '../table/DataTable'
import PaginationVue from '../table/Pagination';

export default {
     components:{
        Datepicker,
        dataTable:DataTable,
        pagination:PaginationVue
    },
    setup() {
        // In case of a range picker, you'll receive [Date, Date]
        const format = (d) => {
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();

            return  month+ "-" + day  + "-" + year;
        }
        
        return {
            format,
        }
    },
    data(){

        let sortOrders = {};
        let columns =[
        {label:'Reservation Number', name:'reservation_number'},
        {label:'Menu', name:null},
        {label:'Total', name:null},
        {label:'Number of Person', name:null},
        {label:'Reservation Date', name:'reservation_date'},
        {label:'Reservation Time', name:'reservation_time'},
        {label:'Status', name:null},
        {label:'Request Date', name:'created_at'},
        // {label:' ', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return{
            post:{},
            errors:[],
            products:[],
            dataset:{
                search:''
            },
            canda:{},
            categories:[],
            product:{},
            reserves:[],
            btncap: "Book",
            bookings:[],
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
    methods:{
        showMenu(){
            $('.menu-list').modal('show');
        },
        listCategory(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/list-category').then(res=>{
                    this.categories = res.data;
                });
            });
        },
        listOfProductWithFilter(filter){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/product-filter/'+filter,{params:this.dataset}).then(res=>{
                    this.products = res.data;
                });
            });
        },
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        convertJsonString(data){
            let cvs = ({'json_data':JSON.stringify(data)})
            this.saveToReserve(cvs)
            // this.$emit('trayscount',data);
        },
        saveToReserve(data){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true;
                this.$axios.post('api/reservation-json', data).then(res=>{
                    this.btndis = false;
                    $('.order-menu').modal('hide');
                }).catch(err=>{

                });
            });
        },
        addReserve(res){
             let data = res;

            if(this.reserves.length > 0){
                let cn =  this.reserves.filter(res=>res.product_id == data.id);
                let ck = cn[0] == undefined ? 0 : cn[0].product_id;

               if(ck == data.id){
                    let result = 0;
                    result = cn[0].quantity + 1;
                    let data = {'quantity': result};
                    let item = this.reserves.find(e =>e.product_id === cn[0].product_id);
                    let idx = this.reserves.indexOf(item);
                    this.reserves[idx].quantity = result;      
                    this.reserves[idx].total = result + this.reserves[idx].price;      
                    this.convertJsonString(this.reserves);
                    this.$emit('show',{'message':'Menu has been added your order!', 'status':4});
              }else{
                this.product = {
                    'product_id': data.id,
                    'image': data.image,
                    'code': data.code,
                    'name': data.name,
                    'description': data.description,
                    'food_category_id': data.food_category_id,
                    'price': data.price,
                    'quantity': 1,
                    'total': data.price
                };
               
                this.reserves.push(this.product);
                this.convertJsonString(this.reserves);
                this.$emit('show',{'message':'Menu has been added your order!', 'status':4});

              }
            }else{

                this.product = {
                    'product_id': data.id,
                    'image': data.image,
                    'code': data.code,
                    'name': data.name,
                    'description': data.description,
                    'food_category_id': data.food_category_id,
                    'price': data.price,
                    'quantity': 1,
                    'total': data.price
                };

                this.reserves.push(this.product);
                this.convertJsonString(this.reserves);
                this.$emit('show',{'message':'Menu has been added your order!', 'status':4});
               
            }
        },
         reservationJson(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/reservation-json').then(res=>{
                    if(res.data.json_data != undefined){
                        let data = JSON.parse(res.data.json_data);
                        this.reserves  = data;
                    }
                   
                });
            });
        },

        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        minusQty(menu){
            let result = (menu.quantity == 1) ? 1 : menu.quantity - 1;
            let data = {'quantity': result};
            let item = this.reserves.find(e =>e.product_id === menu.product_id);
            let idx = this.reserves.indexOf(item);
            this.reserves[idx].quantity = result;  
            this.reserves[idx].total = result * menu.price;        
            this.convertJsonString(this.reserves);
          
        },
        addQty(menu){
            let result = 0;
            result = menu.quantity + 1;
            let data = {'quantity': result};
            let item = this.reserves.find(e =>e.product_id === menu.product_id);
            let idx = this.reserves.indexOf(item);
            this.reserves[idx].quantity = result; 
            this.reserves[idx].total = result * menu.price;        
            this.convertJsonString(this.reserves);
        },
        removeFromTray(id){
            this.reserves.forEach((val, index)=>{
                if(id == val.product_id){
                    this.reserves.splice(index, 1);
                }
            });
            this.convertJsonString(this.reserves);
        },
        grandTotal(data){
            let ret = 0;
            data.forEach((val, index) => {
                ret += val.quantity * val.price;
            });
            return ret;
        },
        saveReservation(){
            this.post.menu = this.reserves;
            this.post.total =this.grandTotal(this.reserves);
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap = "Booking..."
                this.$axios.post('api/reservation', this.post).then(res=>{
                    this.$emit('show',{'message':'Reservation has been Booked!', 'status':4});
                    this.convertJsonString([]);
                    this.btncap = "Book";
                    this.reservationJson();
                    this.errors = [];
                    this.listOfBookings();
                    $('.booking').modal('show');
                }).catch(err=>{
                    this.btncap = "Book";
                    this.errors = err.response.data.errors
                });
            });
        },
        
        listOfBookings(url='api/reservation'){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.tableData.draw ++;
                this.$axios.get(url,{params:this.tableData}).then(res=>{
                    let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.bookings = data.data.data;
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
                this.listOfBookings();
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
        showBooking(){
            this.bookings = [];
            this.tableData.filter = 0;
            this.listOfBookings();
            $('.booking').modal('show');
        },
        setStatus(num){
            return num == 0 ? "Received" : num == 1 ? "Confirmed" :  num == 2 ? "Approved" :num == 3? "Served" :"Canceled";
        },
        payReserve(data){
            $('.booking').modal('hide');
            this.$router.push({name:'payreserve', query:{'reserve':data.reservation_number}});
        },
        showHistory(){
            this.bookings = [];
            this.tableData.filter = 1;
            this.listOfBookings();
            $('.history').modal('show');
        },
        showCancelReserve(data){
            this.canda = data;
            $('.cancel-reserve').modal('show');
        },
        cancelReserve(data){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/reserve-status', {'status':5,'id':data.id})
                    .then(response => {
                        this.listOfBookings();
                        $('.cancel-reserve').modal('hide');
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        finished(data){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/reserve-status', {'status':3,'id':data.id})
                    .then(response => {
                        this.listOfBookings();
                        // $('.cancel-reserve').modal('hide');
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        cancelButton(){
             $('.cancel-reserve').modal('hide');
        }


    },
    mounted() {
        this.listOfProductWithFilter(0);
        this.listCategory();
        this.reservationJson();
        this.listOfBookings();
        if(window.Laravel.isLoggedin){
            let user = window.Laravel.user;
            this.post.full_name = ((user.first_name == null) ? "": user.first_name)+" "+((user.last_name == null) ? "" : user.last_name);
            this.post.mobile_number = user.mobile_number;
        }
    },
}
</script>

<style>

</style>
