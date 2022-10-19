<template>
 <div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <h3 class="title-5 m-b-35">Food Category</h3>
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="rs-select2--light rs-select2--lg">
                                   <input class="au-input au-input--full w-100" type="text" v-model="tableData.search"  placeholder="Search ..." @input="listOfCategory()">
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
                            <button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" @click="showCategoryModal">
                                <i class="zmdi zmdi-plus"></i>add Category</button>
                            <!-- <div class="rs-select2--dark rs-select2--sm rs-select2--dark2">
                                <select class="js-select2" name="type">
                                    <option selected="selected">Export</option>
                                    <option value="">Option 1</option>
                                    <option value="">Option 2</option>
                                </select>
                                <div class="dropDownSelect2"></div>
                            </div> -->
                        </div>
                    </div>
                    <data-table class="mt-2" :columns="columns" :sortKey="sortKey" :sortOrders="sortOrders" @sort="sortBy">
                    <tbody v-for="(list, idx) in categories" :key="idx">
                            <tr class="tr-shadow">
                                <td class="desc">{{ list.category_name}}</td>
                                <td>
                                    <span>{{list.description }}</span>
                                </td>
                                <td>
                                    <div class="table-data-feature">
                                        <!-- <button class="item" data-toggle="tooltip" data-placement="top" title="Send">
                                            <i class="zmdi zmdi-mail-send"></i>
                                        </button> -->
                                        <button class="item" data-toggle="tooltip" data-placement="top"  @click="editCategoryModal(list)" title="Edit">
                                            <i class="zmdi zmdi-edit"></i>
                                        </button>
                                        <!-- <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="More">
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
                            @prev="listOfCategory(pagination.prevPageUrl)"
                            @next="listOfCategory(pagination.nextPageUrl)"
                            v-show="noData(categories)">
                        </pagination>
                    </div>
                    <!-- END DATA TABLE -->
                </div> 
            </div>
        </div>
    </div>
     <div class="modal fade food-category" id="food-category" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mediumModalLabel">Food Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input class="au-input au-input--full" type="text" v-model="post.category_name"  placeholder="Category Name">
                            <span class="errors-material" v-if="errors.category_name">{{errors.category_name[0]}}</span>
                            
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <input class="au-input au-input--full" type="text"  v-model="post.description"  placeholder="Description">
                            <span class="errors-material" v-if="errors.description">{{errors.description[0]}}</span>

                        </div>
                       
                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button> -->
                    <button type="button" class="btn btn-primary" @click="saveCategory">Save</button>
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
        {label:'Category Name', name:'category_name'},
        {label:'Description', name:'description'},
        {label:'Action', name:null},
        ];
        
        columns.forEach(column=>{
            sortOrders[column.name] = -1;
        });
        return {
            categories:[],
            post:{},
            errors:[],
            columns:columns,
            sortOrders:sortOrders,
            sortKey:'created_at',
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
        }
    },
    methods: {
        showCategoryModal(){
            $('#food-category').modal('show');
        },

        editCategoryModal(data){
            this.post = data;
            $('#food-category').modal('show');
        },
        saveCategory(){
            if(this.post.id > 0){
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.$axios.put('api/category/'+this.post.id,this.post).then(res=>{
                        this.post = {};
                        this.$emit('show',{'message':'Food Category has been Modified!', 'status':4});
                        $('#food-category').modal('hide');
                        this.listOfCategory();
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
            }else{
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                    this.$axios.post('api/category',this.post).then(res=>{
                        this.post = {};
                        this.$emit('show',{'message':'Food Category Added Successfully!', 'status':4});
                        $('#food-category').modal('hide');
                        this.listOfCategory();
                    }).catch(err=>{
                        this.errors = err.response.data.errors
                    });
                });
            }
            
            
        },

        listOfCategory(urls='api/category'){
            this.$axios.get('sanctum/csrf-cookie').then(response => {
                this.tableData.draw ++;
                this.$axios.get(urls,{params:this.tableData}).then(res=>{
                let data = res.data;
                    if(this.tableData.draw == data.draw){
                        this.categories = data.data.data;
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
                this.listOfCategory();
            }
        },
        getIndex(array, key, value){
            return array.findIndex(i=>i[key] == value)
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
    },
    mounted() {
        this.listOfCategory();
    },
}
</script>

<style>

</style>
