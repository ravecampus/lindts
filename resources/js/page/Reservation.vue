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
                        <div class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="small mb-1" >Number Of Person</label>
                                    <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Number of Person">
                                    <span class="errors-material" v-if="errors.number_of_person">{{errors.number_of_person[0]}}</span>
                                </div>
                                <div  class="col-md-4">
                                    <label class="small mb-1" >Reservation Date</label>
                                    <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Reservation Date">
                                    <span class="errors-material" v-if="errors.reservation_date">{{errors.reservation_date[0]}}</span>
                                </div>
                                <div class="col-md-4">
                                    <label class="small mb-1" >Reservation Time</label>
                                    <input class="form-control" v-model="post.number_of_person" type="number" placeholder="Reservation Time">
                                    <span class="errors-material" v-if="errors.reservation_time">{{errors.reservation_time[0]}}</span>
                                </div>
                            </div>
                                <hr>
                                <label class="small mb-1" >Select our </label>
                                <button type="button" @click="showMenu()" class="book-a-table-btn btn-sm-table"><span class="fa fa-plus"></span> Menu</button>
                                <div class="btn-group pull-right">
                                    <button type="button" @click="showMenu()" class="book-a-table-btn btn-sm-table"><span class="fa fa-send"></span> Book</button>
                                    <button type="button" @click="showMenu()" class="book-a-table-btn btn-sm-table"><span class="fa fa-list"></span> List of Booking</button>
                                </div>
                            </div>
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

    </div>
</template>

<script>
export default {
    data(){
        return{
            post:{},
            errors:[],
            products:[],
            dataset:{
                search:''
            },
            categories:[],
            product:{},
            reserves:[],
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
            console.log(res);
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
            this.convertJsonString(this.reserves);
          
        },
        addQty(menu){
            let result = 0;
            result = menu.quantity + 1;
            let data = {'quantity': result};
            let item = this.reserves.find(e =>e.product_id === menu.product_id);
            let idx = this.reserves.indexOf(item);
            this.reserves[idx].quantity = result;      
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
                ret += val.total;
            });
            return ret;
        }
        

    },
    mounted() {
        this.listOfProductWithFilter(0);
        this.listCategory();
        this.reservationJson();
        
        let user = window.Laravel.user;
        this.post.full_name = ((user.first_name == null) ? "": user.first_name)+" "+((user.last_name == null) ? "" : user.last_name);
        this.post.mobile_number = user.mobile_number;
        
        
    },
}
</script>

<style>

</style>
