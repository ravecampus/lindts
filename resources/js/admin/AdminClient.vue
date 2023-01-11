<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Clients</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Search ..." @input="listOfUser()">
                            </div>
                            <button class="au-btn-filter">
                                <i class="zmdi zmdi-filter-list"></i>filters
                            </button>
                        </div>
                        <div class="table-data__tool-right">
                            <!-- <button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" @click="showProductModal">
                                <i class="zmdi zmdi-plus"></i>add User
                            </button> -->
                        
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in users" :key="idx">
                            <tr class="tr-shadow">
                               
                                <td>
                                    <span class="status--process">
                                    {{ list.first_name}} {{ list.last_name }}
                                    </span>
                                    <div class="small">
                                       AGE : {{list.age}}
                                    </div>
                                    <div class="small">
                                        MOBILE # : {{ list.mobile_number }}
                                    </div>
                                    <div class="small">
                                        ADDRESS : {{list.address}}
                                    </div>
                                </td>
                                <td class="desc">{{ list.username}}</td>
                                <td>
                                    <span>{{list.email }}</span>
                                </td>
                                 <td>
                                    <!-- <span>{{list.del_address.length }}</span> -->
                                    <li class="card card-body p-1" v-for="(lsi,idx) in list.del_address" :key="idx">
                                        <div class="small">{{ lsi.full_name  }}</div>
                                        <!-- <div class="small">{{ lsi.mobile_number  }}</div> -->
                                        <div class="small">{{ lsi.address  }}</div>
                                    </li>
                                </td>
                                
                                <td>
                                    <span>{{formatDate(list.created_at) }}</span>
                                </td>
                                <!-- <td>
                                    <div class="table-data-feature">
                                        <button class="item" data-toggle="tooltip"  @click="showPasswordSetup(list)"  data-placement="top">
                                            <i class="zmdi zmdi-lock-open"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" @click="editUserModal(list)" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="More">
                                            <i class="zmdi zmdi-more"></i>
                                        </button>
                                    </div>
                                </td> -->
                            </tr>
                            <tr class="spacer"></tr>
                            
                        </tbody>
                    </data-table>
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listOfUser(pagination.prevPageUrl)"
                            @next="listOfUser(pagination.nextPageUrl)"
                            v-show="noData(users)">
                        </pagination>
                    </div>
                    <div class="card" v-show="!noData(users)">
                        <div class="card-body">
                            <div class="text-center">No Data Found!</div>
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div> 
            </div>
        </div>
    </div>
     <div class="modal fade" id="user" ref="user" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Personal Information</h5>
                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button> -->
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>First Name</label>
                                <input class="au-input au-input--full" type="text" v-model="post.first_name"  placeholder="First Name">
                                <span class="errors-material" v-if="errors.first_name">{{errors.first_name[0]}}</span>
                                
                            </div>
                            <div class="form-group col-md-6">
                                <label>Last Name</label>
                                <input class="au-input au-input--full" type="text"  v-model="post.last_name"  placeholder="Last Name">
                                <span class="errors-material" v-if="errors.last_name">{{errors.last_name[0]}}</span>

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Username</label>
                                <input class="au-input au-input--full" type="text"  v-model="post.username"  placeholder="Username">
                                <span class="errors-material" v-if="errors.username">{{errors.username[0]}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="select" class=" form-control-label">Email</label>
                                <input class="au-input au-input--full" type="text"  v-model="post.email"  placeholder="Email">
                                <span class="errors-material" v-if="errors.email">{{errors.email[0]}}</span>
                            </div>
                        </div>
                        <div class="row" v-if="post.id == undefined ">
                            <div class="form-group col-md-6">
                                <label>Passwword</label>
                                <input class="au-input au-input--full" type="password"  v-model="post.password"  placeholder="Password">
                                <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="select" class=" form-control-label">Password Confirmation</label>
                                <input class="au-input au-input--full" type="password"  v-model="post.password_confirmation"  placeholder="Password Confirmation">
                                <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                            </div>
                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                    <button type="button" class="btn btn-primary" @click="saveUser">{{btncap}}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="passetup" ref="passetup" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Passwword</label>
                            <input class="au-input au-input--full" type="password"  v-model="post.password"  placeholder="Password">
                            <span class="errors-material" v-if="errors.password">{{errors.password[0]}}</span>
                        </div>
                        <div class="form-group">
                            <label for="select" class=" form-control-label">Password Confirmation</label>
                            <input class="au-input au-input--full" type="password"  v-model="post.password_confirmation"  placeholder="Password Confirmation">
                            <span class="errors-material" v-if="errors.password_confirmation">{{errors.password_confirmation[0]}}</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="savePassword()">{{btncap_}}</button>
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
        {label:'Personal Info.', name:null},
        {label:'Username', name:'username'},
        {label:'Email', name:'email'},
        {label:'shipping Address', name:null},
        {label:'Date', name:'created_at'},
        // {label:'Action', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return {
            users:[],
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
            tableData:{
                draw:0,
                length:10,
                search:'',
                column:0,
                filter:0,
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

        listOfUser(urls='api/usersa'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.users = data.data.data;
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
                this.listOfUser();
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
        showPasswordSetup(data){
            this.upload = data
            $('#passetup').modal('show');
        },
       
        savePassword(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btncap_ = "Saving ..."
                this.$axios.post('api/user-password',this.post).then(res=>{
                    this.btncap_ = "Save";
                    this.$emit('show',{'message':'Password has been changed!', 'status':4});
                    this.listOfUser();
                    $('#passetup').modal('hide');
                }).catch(err=>{
                    this.btncap_ = "Save";
                    this.errors = err.response.data.errors
                });
            });
           
        },
        
    },
    mounted() {
        this.listOfUser();
        this.listCategory()

        $(this.$refs.user).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
         $(this.$refs.passetup).on('hidden.bs.modal',()=> {
            this.errors = [];
            this.post = {};
        });
    },
}
</script>

<style>

</style>
