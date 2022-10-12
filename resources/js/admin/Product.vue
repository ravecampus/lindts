<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Products</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Search ..." @input="listProduct()">
                                <!-- <select class="js-select2" name="property">
                                    <option selected="selected">All Properties</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div> -->
                            </div>
                            <!-- <div class="rs-select2--light rs-select2--sm">
                                <select class="js-select2" name="time">
                                    <option selected="selected">Today</option>
                                    <option value="">3 Days</option>
                                    <option value="">1 Week</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div> -->
                            <button class="au-btn-filter">
                                <i class="zmdi zmdi-filter-list"></i>filters</button>
                        </div>
                        <div class="table-data__tool-right">
                            <button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" @click="showProductModal">
                                <i class="zmdi zmdi-plus"></i>add Product</button>
                            <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2" name="type">
                                    <option selected="selected">Export</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div>
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in products" :key="idx">
                            <tr class="tr-shadow">
                                <td><img class="img-thumbnail w-50" :src="list.image == null ? '../images/icon/icon.png' :'../storage/products/'+list.image" />
                                    <div class="">
                                        <a href="#" @click="showUpload(list)" >Edit </a>
                                    </div>
                                </td>
                                <td><span class="status--process">{{ list.code}}</span></td>
                                <td class="desc">{{ list.name}}</td>
                                <td>
                                    <span>{{list.description }}</span>
                                </td>
                                <td>
                                    <span>{{list.category_name }}</span>
                                </td>
                                <td>
                                    <span>{{list.price }}</span>
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
                    <div class="pull-right">
                        <pagination :pagination="pagination"
                            @prev="listOfProduct(pagination.prevPageUrl)"
                            @next="listOfProduct(pagination.nextPageUrl)"
                            v-show="noData(products)">
                        </pagination>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
        {label:'Image', name:'image'},
        {label:'Code', name:'code'},
        {label:'Name', name:'name'},
        {label:'Description', name:'description'},
        {label:'category', name:null},
        {label:'Price', name:'price'},
        {label:'Date', name:'created_at'},
        {label:'Action', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return {
            products:[],
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
        saveProduct(){
            if(this.post.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.$axios.put('api/product/'+this.post.id,this.post).then(res=>{
                        this.$emit('show',{'message':'Product has been Modified!', 'status':4});
                        $('#product').modal('hide');
                        this.listOfProduct();
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
            }else{
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.$axios.post('api/product',this.post).then(res=>{
                        this.$emit('show',{'message':'Product Added Successfully!', 'status':4});
                        $('#product').modal('hide');
                        this.listOfProduct();
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
            }
            
            
        },

        listOfProduct(urls='api/product'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.products = data.data.data;
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
                this.listOfProduct();
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
        showUpload(data){
            this.upload = data
            $('#upload-img').modal('show');
        },
        browseImg(){
            $('#uploader').click();
        },
        uploadImage(e){
            this.img = e.target.files[0];
            this.uploadLogo();
        },
        uploadLogo(){
            this.form.append('image', this.img);
            this.form.append('id',  this.upload.id);
             const config = {
                header:{'Content-Type':'multipart/form-data'},
                    onUploadProgress:(e)=>{
                        this.uploadPercentage_ = parseInt(Math.round((e.loaded * 100)/ e.total));
                        this.showbar = true;
                    }
                };
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/product-upload',this.form, config).then(res=>{
                    this.showbar = false;
                    this.uploadPercentage_ = 0;
                    this.listOfProduct();
                    $('#upload-img').modal('hide');
                }).catch(err=>{
                    this.uploadPercentage_ = 0;
                });
            });
           
        },
        
    },
    mounted() {
        this.listOfProduct();
        this.listCategory()
    },
}
</script>

<style>

</style>
