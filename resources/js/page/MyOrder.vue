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

           <div v-for="(lst,idx) in products" :key="idx" class="col-lg-4 menu-item" v-bind:class="'L'+lst.food_category_id">
              <div class="card product-shadow">
                <div class="card-body">
                  <div class="menu-img">
                    <img :src="lst.image == null ? '../images/icon/icon.png' :'../storage/products/'+lst.image" class="m-img" alt="">
                    <!-- <span></span> -->
                    <div>
                        <a class="book-a-table-btn btn-sm-table" @click="orderMenu(lst)" href="#">Order</a>
                    </div>
                  </div>
                  <div class="menu-content mt-0">
                    <a href="#">{{lst.name}}</a><span>&#8369;{{formatAmount(lst.price)}}</span>
                  </div>
                  <div class="menu-ingredients">
                   {{lst.description}}
                  </div>
                </div>
              </div>
          </div>

        </div>
        <div class="card" v-show="!noData(products)">
            <div class="card-body">
                <div class="text-center">No Menu Found!</div>
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
export default {
    data(){
        return{
            trays:[],
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
            btndis: false
        }
    },
    mounted() {
        this.listOfOrderAuth(1);
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

        listOfOrderAuth(filter){
             
                this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/order-auth/'+filter,{params:this.dataset}).then(res=>{
                    this.products = res.data;
                });
            });
        },
        noData(data){
            return data == undefined ? true : (data.length > 0) ? true : false;
        },
        
        formatAmount(num){
            let val = (num/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },


    }
}
</script>

<style>

</style>
