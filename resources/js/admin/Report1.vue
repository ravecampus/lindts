<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h1 class="text-center d-none d-print-block mb-3">{{ title }} </h1>
                    <h3 class="title-5 m-b-35">Sales Reservation Report </h3>
                    <div class="table-data__tool">
                        <div class="d-none d-print-block mb-3">
                            <div class="small">Print Date: {{ formatDate(Date()) }}</div>
                            <!-- <h4>University Southern Mindanao</h4>
                            <h5>Online Document Request System</h5> -->
                        </div>
                        <div class="table-data__tool-left d-print-none">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Search ..." @input="listOfSalesOrder()">
                            </div>
                            <div class="rs-select2--light rs-select2--lg">
                                <Datepicker v-model="post.date_from" placeholder="From" :format="format"/>
                            </div>
                             <div class="rs-select2--light rs-select2--lg">
                                <Datepicker v-model="post.date_to" placeholder="To" :format="format"/>
                            </div>
                         
                            <button class="au-btn-filter mr-1" @click="filterReport()">
                                <i class="zmdi zmdi-filter-list"></i>filters
                            </button>
                            <button class="au-btn-filter" v-if="orders.length > 0" @click="printReport()">
                                <i class="zmdi zmdi-print"></i>Print
                            </button>
                        </div>
                        <div class="table-data__tool-right">
                            <!-- <button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" @click="showProductModal">
                                <i class="zmdi zmdi-plus"></i>add User
                            </button> -->
                        
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in orders" :key="idx">
                            <tr class="tr-shadow">
                               
                                <td>
                                    <span class="status--process">
                                        {{ list.reservation_number}}
                                    </span>
                                   
                                </td>
                                <td class="desc">{{ formatDate(list.created_at) }}</td>
                                <td>
                                    <span>{{list.full_name }}</span>
                                </td>
                                <!-- <td>
                                    <span>{{list.payment_mode == 1 ? "Delivery" :"Walkin" }}</span>
                                </td> -->
                                 <td>
                                    {{ formatAmount(list.total) }}
                                </td>
                                <td>{{ setStatus(list.status) }}</td>
                            </tr>
                            <tr class="spacer"></tr>
                           
                        </tbody>
                        <tbody v-show="noData(orders)">
                            <tr>
                                <td colspan="3">
                                    <div class="pull-right">TOTAL : </div>
                                </td>
                                <td colspan="2"> <strong>
                                    {{formatAmount(gTotal(orders)) }}
                                    </strong>
                                </td>
                            </tr>
                        </tbody>
                    </data-table>
                    <div class="pull-right  d-print-none">
                        <pagination :pagination="pagination"
                            @prev="listOfSalesOrder(pagination.prevPageUrl)"
                            @next="listOfSalesOrder(pagination.nextPageUrl)"
                            v-show="noData(orders)">
                        </pagination>
                    </div>
                    <div class="card d-print-none" v-show="!noData(orders)">
                        <div class="card-body">
                            <div class="text-center">No Data Found!</div>
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
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

    data() {
        let sortOrders = {};
        let columns =[
        {label:'Order #', name:'order_number'},
        {label:'Order Date', name:'created_at'},
        {label:'Client', name:null},
        // {label:'Payment Mode', name:null},
        {label:'Amount', name:null},
        {label:'Status', name:null},
        
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
            btncap:'Save',
            btncap_:'Save',
            title:"",
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                filter:0,
                date_from: null,
                date_to: null,
                dir:'desc',
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
    methods: {
        showProductModal(){
            $('#user').modal('show');
        },

        editUserModal(data){
            this.post = data;
            $('#user').modal('show');
        },
        saveUser(){
            if(this.post.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap = "Saving ...";
                    this.$axios.put('api/usersa/'+this.post.id,this.post).then(res=>{
                        this.$emit('show',{'message':'User has been Modified!', 'status':4});
                        this.post = {};
                        this.btncap = "Save";
                        $('#user').modal('hide');
                        this.listOfUser();
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
            }else{
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.btncap = "Saving ...";
                    this.$axios.post('api/usersa',this.post).then(res=>{
                        this.$emit('show',{'message':'User Added Successfully!', 'status':4});
                        this.post = {};
                        $('#user').modal('hide');
                        this.btncap = "Save";
                        this.listOfUser();
                    }).catch(err=>{
                        this.btncap = "Save";
                        this.errors = err.response.data.errors
                    });
                });
            }
            
            
        },

        listOfSalesOrder(urls='api/sales-reserve'){
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
                this.listOfSalesOrder();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        formatDate(da){
            let d = new Date(da);
            const day =("0" + d.getDate()).slice(-2);
            const month = ("0"+(d.getMonth()+1)).slice(-2);
            const year =  d.getFullYear();
            return  month+ "-" + day  + "-" + year;
        },
        showPasswordSetup(data){
            this.upload = data
            $('#passetup').modal('show');
        },
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        filterReport(){
            this.tableData.date_from = this.post.date_from;
            this.tableData.date_to = this.post.date_to;
            this.listOfSalesOrder();
        },
        printReport(){
            window.print();
        },
        gTotal(data){
            let lst = data;
            let ret = 0;
            lst.forEach(val => {
                ret += val.total;
            });

            return ret;
        },
        setStatus(num){
            return num == 0 ? "Received" : num == 1 ? "Confirmed" :  num == 2 ? "Approved" :num == 3? "Served" :"Canceled";
        },
        
    },
    mounted() {
        this.listOfSalesOrder();
        this.title = window.Title.app_name;
    },
}
</script>

<style>

</style>
