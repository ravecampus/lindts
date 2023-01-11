<template>
<div>
    <section id="topbar" class="d-flex align-items-center fixed-top d-print-none">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-center justify-content-lg-start">
        <i class="bi bi-phone d-flex align-items-center"><span>{{ setting.mobile_number }}</span></i>
        <i class="bi bi-clock ms-4 d-none d-lg-flex align-items-center"><span>{{ setting.schedule }}</span></i>
        </div>
    </section>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center d-print-none">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <div class="logo me-auto">
       
         <router-link :to="{name:'dashboard'}">
           <h1 class="text-white title-design"> <img :src="'../images/icon/iconlidts-1.png'"   class="img-fluid" alt="Lindt's Food" />
            Lindt's Food</h1>
         </router-link>
       
      </div>

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><router-link class="nav-link scrollto" :to="{name:'dashboard'}">Home</router-link></li>
          <!-- <li><a class="nav-link scrollto" href="#about">About</a></li> -->
          <li><router-link class="nav-link scrollto" :to="{name:'menu'}">Menu</router-link></li>
         
          <li><router-link :to="{name:'reservation'}" class="nav-link scrollto">Reservations</router-link></li>
           <li v-if="auth" class="dropdown"><a href="#"><span><strong class="text-uppercase">{{ user.first_name }} {{ user.middle_name }} {{ user.last_name }}</strong></span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><router-link :to="{name:'myprofile'}"><strong>Profile</strong></router-link>
              </li>
              <li><router-link :to="{name:'myorder'}">My Orders</router-link></li>
              <!-- <li><a href="#">Bookings</a></li> -->
              <li><a @click="logout()" href="#">Sign out</a></li>
            </ul>
          </li>
          <li v-if="!auth"><router-link class="nav-link scrollto" :to="{name:'signin'}" >Sign in</router-link></li>
          <li v-if="!auth"><router-link class="nav-link scrollto" :to="{name:'signup'}">Sign up</router-link></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="#" @click="showTrayModal()" class="book-a-table-btn scrollto">Tray <span class="badge badge-light text-warning">{{lenst}}</span></a>
    
    </div>
  </header><!-- End Header -->
  <flashmessage :message="message" :status="status"></flashmessage>
  <router-view @show="flashMessage" @trayscount="countTrays"></router-view>
     <div class="modal fade tray" ref="tray" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-body">
                  <div class="container h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                      <div class="col-12">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                          <div class="card-body p-0">
                            <div class="row g-0">
                              <div class="col-lg-8">
                                <div class="p-5">
                                  <div class="d-flex justify-content-between align-items-center mb-5">
                                    <h3 class="fw-bold mb-0 text-black title-design">Menu Tray</h3>
                                    <h6 class="mb-0 text-muted">{{ this.lenst }} items</h6>
                                  </div>
                                  <hr class="my-4">
                                  <div v-for="(list, index) in trays" :key="index">
                                    <div class="row mb-4 d-flex justify-content-between align-items-center">
                                        <div class="col-md-2 col-lg-2 col-xl-2 menu-img">
                                           <img :src="list.image == null ? '../images/icon/icon.png' :'../storage/products/'+list.image" class="m-img img-sm" alt="">
                                        </div>
                                        <div class="col-md-3 col-lg-3 col-xl-3">
                                          <h6 class="text-muted">{{ list.name }}</h6>
                                          <h6 class="text-black mb-0">{{ list.description }}</h6>
                                        </div>
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
                                        <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                          <h6 class="mb-0">&#8369; {{formatAmount(list.price)}}</h6>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                          <a href="#!" @click="removeFromTray(list.product_id)" class="text-muted btn-qty"><i class="fas fa-times"></i></a>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                  </div>
                                  <div class="pt-5">
                                    <h6 class="mb-0"><a href="#" @click="backToMenu" class="text-body"><i
                                          class="fas fa-long-arrow-alt-left me-2"></i>Back to menu</a></h6>
                                  </div>
                                </div>
                              </div>
                              <div class="col-lg-4 bg-grey">
                                <div class="p-5">
                                  <h5 class="fw-bold mb-5 mt-2 pt-1">Summary</h5>
                                  <hr class="my-4">

                                  <div class="d-flex justify-content-between mb-4">
                                    <h5 class="text-uppercase">items {{ this.lenst }}</h5>
                                    <h5>&#8369; {{ formatAmount(totalAmount(trays)) }}</h5>
                                  </div>

                                  <hr class="my-4">
                                  <h5 class="text-uppercase mb-3">Payment Mode</h5>

                                  <div class="mb-5">
                                    <div class="form-outline">
                                    <select v-model="order.payment_mode" class="form-control" @change="paymethod()">
                                        <option value="1">Deliver</option>
                                        <option value="2">Walk in</option>
                                    </select>
                                    <span class="errors-material" v-if="errors_p.payment_mode">{{errors_p.payment_mode[0]}}</span>

                                      <!-- <label class="form-label" for="form3Examplea2">Enter your code</label> -->
                                    </div>
                                  </div>
                                  <hr class="my-4" v-if="showshipad">

                                  <h5 class="text-uppercase mb-3" v-if="showshipad">Delivery</h5>

                                  <div class="mb-4 pb-2" v-if="showshipad">
                                      <h6> Standard Delivery Fee: &#8369;{{ formatAmount(shipfee.amount == undefined ? 0 : shipfee.amount) }}</h6>
                                  </div>
                                  <i class="small border-bottom">Delivery infomation:</i>
                                  <div class="d-flex justify-content-between mb-5 pt-2" v-if="showshipad">
                                 
                                    <div class="text-uppercase">
                                        <strong>{{ user_d_addr.full_name }}</strong>
                                        <p class="p-0 m-0">{{ user_d_addr.address }}</p>
                                        <!-- <p class="small p-0">({{ user_d_addr.mobile_number }})</p> -->
                                    </div>
                                    <div>
                                      <div class="btn-group">
                                        <a class="btn btn-warning btn-sm" href="#" @click="showShippingList()"><i class="fa fa-list"></i></a>
                                        <a class="btn btn-warning btn-sm" href="#" @click="showShippingAddress()"><i class="fa fa-plus"></i></a>
                                      </div>
                                    </div>
                                  </div>
                                  <li v-if="errors_p.full_name">
                                    <span class="errors-material">{{errors_p.full_name[0]}}</span>
                                  </li>
                                  <li v-if="errors_p.delivery_address">
                                    <span class="errors-material" >{{errors_p.delivery_address[0]}}</span>

                                  </li>
                                  <!-- <li  v-if="errors_p.mobile_number">
                                    <span class="errors-material">{{errors_p.mobile_number[0]}}</span>

                                  </li> -->
                                  <p v-if="!showshipad"> Please bring order slip to the Store!</p>
                                  <hr class="my-4">
                                  <div class="d-flex justify-content-between mb-5">
                                    <h5 class="text-uppercase">Total price</h5>
                                    <h5>&#8369; {{ formatAmount(grandTotalAmount()) }} </h5>
                                  </div>

                                  <button type="button" v-if="trays.length > 0" @click="placeOrder()" class="btn book-a-table-btn btn-block btn-lg"
                                    data-mdb-ripple-color="dark">Place Order</button>

                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> 
            </div>
        </div>
    </div>

    <div class="modal fade shipping-address" tabindex="1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header bg-secondary">
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-warning">Shipping Address</h4>
                            <div class="form-group">
                                <label>Full name</label>
                                <input class="au-input au-input--full"  type="text" v-model="post.full_name" placeholder="Full name">
                                <span class="errors-material" v-if="errors_.full_name">{{errors_.full_name[0]}}</span>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input class="au-input au-input--full"  type="text" v-model="post.address" placeholder="Address">
                                <span class="errors-material" v-if="errors_.full_name">{{errors_.address[0]}}</span>
                            </div>
                            <!-- <div class="form-group">
                                <label>Mobile Number</label>
                                <input class="au-input au-input--full"  type="text" v-model="post.mobile_number" placeholder="Mobile number">
                                <span class="errors-material" v-if="errors_.mobile_number">{{errors_.mobile_number[0]}}</span>
                            </div> -->
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center bg-secondary">
                    <button type="button" :disabled="btndis" @click="saveShippingAddr()" class="book-a-table-btn">{{ btncap }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade shipping-list" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header bg-secondary">
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-warning">List of Shipping Address</h4>
                           
                            <ul class="list-group">
                              <li v-for="(shps, idx) in shipaddrs" :key="idx" class="list-group-item d-flex justify-content-between">
                                <div>{{ shps.full_name }}</div>
                                <div>{{ shps.address }}</div>
                                <!-- <div>{{ shps.mobile_number }}</div> -->
                                <div>
                                  <label class="switch switch-3d switch-primary mr-3" size="sm">
                                    <input type="checkbox" class="switch-input" :checked="chkShip(shps)" @change="changeDefault(shps)">
                                    <span class="switch-label"></span>
                                    <span class="switch-handle"></span>
                                  </label>
                                </div>
                                <div class="table-data-feature">
                                    <button class="item" data-toggle="tooltip"  @click="editShipAddress(shps)" title="Edit">
                                      <i class="zmdi zmdi-edit"></i>
                                    </button>
                                </div>
                              </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center bg-secondary">
                    <!-- <button type="button" class="book-a-table-btn">{{btncap}}</button> -->
                </div>
            </div>
        </div>
    </div>

     <div class="modal fade confirmed-order" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
               <div class="modal-header bg-secondary">
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="text-warning">Do you want to Place your Order?</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center bg-secondary">
                    <button type="button" @click="confirmedPlaceOrder()" class="btn btn-warning btn-sm">Yes</button>
                    <button type="button" @click="cancelButton()" class="btn btn-secondary btn-sm">No</button>
                </div>
            </div>
        </div>
    </div>

 
<footer id="footer">
    <div class="container d-print-none">
      <h3 class="title-design">{{title}}</h3>
      <p>Making the world a better place one plate at a time.</p>
      <div class="social-links">
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
      <div class="copyright">
        &copy; Copyright <strong><span>{{title}}</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        Designed by <a href="#">winsdev's</a>
      </div>
    </div>
  </footer><!-- End Footer -->
  <link-auth></link-auth>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
</div>
    
</template>

<script>
import FlashMessage from './FlashMessage.vue';
import LinkAuth from './LinkNotAuth';

export default {
  components:{
        flashmessage: FlashMessage,
        linkAuth:LinkAuth
  },
  data() {
    return {
      title:'',
      message:'',
      status:0,
      lenst:0,
      trays:[],
      post:{},
      errors:[],
      errors_:[],
      errors_p:[],
      order:{},
      user:{},
      showshipad: true,
      btndis : false,
      btncap:'Save',
      shipaddrs:[],
      user_d_addr:{},
      setting:{},
      shipfee:{},
      auth:false,
    }
  },
    mounted() {
	  let user = window.Laravel.user;
    let ship = window.Laravel.shipping_address;
    
    this.user = user;

      this.title = window.Title.app_name;
      this.auth = window.Laravel.isLoggedin;
      if(window.Laravel.isLoggedin){
          this.trayDefault();
          this.userTray();
          this.listShippingAddr();
          this.userDefaultShip();
          this.getDeliveryFee();
      }
       this.getSetting();

      if(window.Laravel.isLoggedin){
          let user = window.Laravel.user;
          this.auth = true;
          if(user.role == 1){
              this.$router.push({name:'admin'})
          }else if(user.role == 0){
          //    this.$router.push({name:'user'})
          }
      }
   
      this.order.payment_mode = 1;

      const select = (el, all = false) => {
        el = el.trim()
        if (all) {
          return [...document.querySelectorAll(el)]
        } else {
          return document.querySelector(el)
        }
      }

      /**
       * Easy event listener function
       */
      const on = (type, el, listener, all = false) => {
        let selectEl = select(el, all)
        if (selectEl) {
          if (all) {
            selectEl.forEach(e => e.addEventListener(type, listener))
          } else {
            selectEl.addEventListener(type, listener)
          }
        }
      }

      /**
       * Easy on scroll event listener 
       */
      const onscroll = (el, listener) => {
        el.addEventListener('scroll', listener)
      }

      /**
       * Navbar links active state on scroll
       */
      let navbarlinks = select('#navbar .scrollto', true)
      const navbarlinksActive = () => {
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
          if (!navbarlink.hash) return
          let section = select(navbarlink.hash)
          if (!section) return
          if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
            navbarlink.classList.add('active')
          } else {
            navbarlink.classList.remove('active')
          }
        })
      }
      window.addEventListener('load', navbarlinksActive)
      onscroll(document, navbarlinksActive)

      /**
       * Scrolls to an element with header offset
       */
      const scrollto = (el) => {
        let header = select('#header')
        let offset = header.offsetHeight

        let elementPos = select(el).offsetTop
        window.scrollTo({
          top: elementPos - offset,
          behavior: 'smooth'
        })
      }

      /**
       * Toggle .header-scrolled class to #header when page is scrolled
       */
      let selectHeader = select('#header')
      let selectTopbar = select('#topbar')
      if (selectHeader) {
        const headerScrolled = () => {
          if (window.scrollY > 100) {
            selectHeader.classList.add('header-scrolled')
            if (selectTopbar) {
              selectTopbar.classList.add('topbar-scrolled')
            }
          } else {
            selectHeader.classList.remove('header-scrolled')
            if (selectTopbar) {
              selectTopbar.classList.remove('topbar-scrolled')
            }
          }
        }
        window.addEventListener('load', headerScrolled)
        onscroll(document, headerScrolled)
      }

      /**
       * Back to top button
       */
      let backtotop = select('.back-to-top')
      if (backtotop) {
        const toggleBacktotop = () => {
          if (window.scrollY > 100) {
            backtotop.classList.add('active')
          } else {
            backtotop.classList.remove('active')
          }
        }
        window.addEventListener('load', toggleBacktotop)
        onscroll(document, toggleBacktotop)
      }

      /**
       * Mobile nav toggle
       */
      on('click', '.mobile-nav-toggle', function(e) {
        select('#navbar').classList.toggle('navbar-mobile')
        this.classList.toggle('bi-list')
        this.classList.toggle('bi-x')
      })

      /**
       * Mobile nav dropdowns activate
       */
      on('click', '.navbar .dropdown > a', function(e) {
        if (select('#navbar').classList.contains('navbar-mobile')) {
          e.preventDefault()
          this.nextElementSibling.classList.toggle('dropdown-active')
        }
      }, true)

      /**
       * Scrool with ofset on links with a class name .scrollto
       */
      on('click', '.scrollto', function(e) {
        if (select(this.hash)) {
          e.preventDefault()

          let navbar = select('#navbar')
          if (navbar.classList.contains('navbar-mobile')) {
            navbar.classList.remove('navbar-mobile')
            let navbarToggle = select('.mobile-nav-toggle')
            navbarToggle.classList.toggle('bi-list')
            navbarToggle.classList.toggle('bi-x')
          }
          scrollto(this.hash)
        }
      }, true)

      /**
       * Scroll with ofset on page load with hash links in the url
       */
      window.addEventListener('load', () => {
        if (window.location.hash) {
          if (select(window.location.hash)) {
            scrollto(window.location.hash)
          }
        }
      });

    },

    methods: {
       linkauth(){
            $('.notauth').modal('show');
      },
       flashMessage(data){
             this.showMessage(data)
        },
        showMessage(data){
            this.message = data.message;
            if(data.status == 1){
                this.status = 'alert-success';
            }else if(data.status == 2){
                this.status = 'alert-warning';
            }else if(data.status == 3){
                this.status = 'alert-danger';
            }else if(data.status == 4){
                this.status = 'alert-secondary';
            }else if(data.status == 5){
                this.status = 'alert-dark';
            }else if(data.status == 6){
                this.status = 'alert-light';
            }else if(data.status == 7){
                this.status = 'alert-primary';
            }
            $('.fm-body').show();
            setTimeout(() => {
                $('.fm-body').fadeOut("slow");
            }, 500);
        },
        countTrays(data){
          let cc = 0;
          data.forEach(res => {
              cc += res.quantity;
          });
          this.lenst = cc;
        }, 
        trayDefault(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-list-tray').then(res=>{
                    let oncart = JSON.parse(res.data.json_data);
                    let cc_ = 0
                    oncart.forEach(res => {
                        cc_ += res.quantity;
                    });
                    this.lenst = cc_;
                });
            });
        },
        showTrayModal(){
           if(!window.Laravel.isLoggedin){
                this.linkauth();
                return;
            }
          this.userTray();
          $('.tray').modal('show');
        },
        userTray(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/user-list-tray').then(res=>{
                    let data = JSON.parse(res.data.json_data);
                    this.trays  = data;
                });
            });
        },
        minusQty(menu){
            let result = (menu.quantity == 1) ? 1 : menu.quantity - 1;
            let data = {'quantity': result};
            let item = this.trays.find(e =>e.product_id === menu.product_id);
            let idx = this.trays.indexOf(item);
            this.trays[idx].quantity = result;      
            this.convertJsonString(this.trays);
          
        },
        addQty(menu){
            let result = 0;
            result = menu.quantity + 1;
            let data = {'quantity': result};
            let item = this.trays.find(e =>e.product_id === menu.product_id);
            let idx = this.trays.indexOf(item);
            this.trays[idx].quantity = result;      
            this.convertJsonString(this.trays);
        },
        convertJsonString(data){
            let cvs = ({'json_data':JSON.stringify(data)})
            this.saveToTray(cvs)
            this.countTrays(data);
        },
        saveToTray(data){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true;
                this.$axios.post('api/user-tray', data).then(res=>{
                }).catch(err=>{

                });
            });
        },
        totalAmount(data){
            let subtotal_ = 0;
            let subtotal = 0;
            data.forEach((val, index)=>{
                subtotal_ = val.quantity * val.price;
                subtotal = subtotal + subtotal_;
            });
            return subtotal;
        },
        formatAmount(num){
            let num_ = Number(num);
            let val = (num_/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },
        removeFromTray(id){
            this.trays.forEach((val, index)=>{
                if(id == val.product_id){
                    this.trays.splice(index, 1);
                }
            });
            this.countTrays(this.trays);
            this.convertJsonString(this.trays);
        },
        backToMenu(){
          $('.tray').modal('hide');
          this.$router.push({name:'menu'});
        },
        showShippingAddress(){
          $('.shipping-address').modal('show');
        },
        showShippingList(){
           $('.shipping-list').modal('show');
        },
        paymethod(){
            let num = this.order.payment_mode;
            this.getDeliveryFee();
            if(num == 1){
                this.showshipad = true;
            }else{
              this.showshipad = false;
            }
        },
        saveShippingAddr(){
          if(this.post.id > 0){
              this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true;
                this.btncap = 'Saving ...';
                this.$axios.put('api/shipping-address/'+this.post.id,this.post).then(res=>{
                    this.post = {};
                    this.btndis = false;
                    this.btncap = 'Save';
                    this.listShippingAddr();
                    this.userDefaultShip();
                    $('.shipping-address').modal('hide');
                    $('.shipping-list').modal('show');
                }).catch(err=>{
                    this.btndis = false;
                    this.btncap = 'Save';
                    this.errors_ = err.response.data.errors
                })

            });
          }else{
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.btndis = true;
                this.btncap = 'Saving ...';
                this.$axios.post('api/shipping-address',this.post).then(res=>{
                    this.post = {};
                    this.btndis = false;
                    this.btncap = 'Save';
                    this.listShippingAddr();
                    this.userDefaultShip();
                    $('.shipping-address').modal('hide');
                    $('.shipping-list').modal('show');
                }).catch(err=>{
                    this.btndis = false;
                    this.btncap = 'Save';
                    this.errors_ = err.response.data.errors
                })

            });
          }
         
		    },
        listShippingAddr(){
          this.$axios.get('sanctum/csrf-cookie').then(response=>{
            this.$axios.get('api/shipping-address').then(res=>{
              this.shipaddrs = res.data;
            })
                });
        },
        chkShip(data){
          return (data.default == 1) ? true : false;
        },
        changeDefault(data){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/shipping-address-default/',data).then(res=>{
                  this.userDefaultShip();
                  this.listShippingAddr();
                }).catch(err=>{

                });
            });
        },
        userDefaultShip(){

           this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/shipping-address-auth').then(res=>{
                    this.user_d_addr = res.data;
                }).catch(err=>{

                });
            });
        },

        getSetting(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/setting-get').then(res=>{
                    this.setting = res.data;
                });
            });
        },
        getDeliveryFee(){
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.get('api/delivery-fee-get').then(res=>{
                    this.shipfee = res.data;
                });
            });
        },

        grandTotalAmount(){
            let amount = this.shipfee.amount == undefined ? 0 : this.shipfee.amount;
            let delfee = this.showshipad ? amount : 0;
            let subtotal = this.totalAmount(this.trays);
            return delfee + subtotal;
        },
        placeOrder(){
            let amount = this.shipfee.amount == undefined ? 0 : this.shipfee.amount;
            this.order.trays = this.trays;
            this.order.full_name = this.user_d_addr.full_name;
            this.order.delivery_address = this.user_d_addr.address;
            this.order.mobile_number = this.user_d_addr.mobile_number;
            this.order.delivery_fee = amount;
            this.order.total = this.totalAmount(this.trays);
            this.order.grand_total = this.totalAmount(this.trays) + amount;
            // console.log(this.order)
            $('.confirmed-order').modal('show');
           
        },
        confirmedPlaceOrder(){
            let num = this.order.payment_mode;
            this.$axios.get('sanctum/csrf-cookie').then(response=>{
                this.$axios.post('api/order',this.order).then(res=>{
                  let orn = res.data.order_number;
                  $('.confirmed-order').modal('hide');
                  $('.tray').modal('hide');
                  this.flashMessage({'message':'Orders Placed Successfully!', 'status':4});
                  this.deleteTray();
                  if(num == 1){
                    this.$router.push({name:'payment',query:{'order':orn}});
                  }else{
                    this.$router.push({name:'slip',query:{'order':orn}});
                  }
                }).catch(err=>{
                  $('.confirmed-order').modal('hide');
                  this.flashMessage({'message':'Oops, Something went wromg!', 'status':3});
                  this.errors_p = err.response.data.errors
                });
            });
        },
        deleteTray(){
          this.convertJsonString([]);
          this.trayDefault();
        },
        logout(){
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } 
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        editShipAddress(data){
            this.post = data;
            $('.shipping-list').modal('hide');
            $('.shipping-address').modal('show');
        },
        cancelButton(){
          $('.confirmed-order').modal('hide');
        }

        
    },
}
</script>

<style>

</style>
