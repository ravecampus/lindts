<template>
        <div class="page-wrapper">
       
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <a class="logo" href="index.html">
                            <img :src="'../images/icon/iconlidts.png'" alt="Lindt's Food" />
                        </a>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="has-sub">
                            <router-link :to="{name:'admindashboard'}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</router-link>
                           
                        </li>
                        <li>
                            <router-link :to="{name:'food_category'}">
                                <i class="fas fa-list-alt"></i>Food Category</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'products'}">
                                <i class="fas fa-pencil-square"></i>Products</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'adminorder'}">
                                <i class="far fa-check-square"></i>Orders</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'adminreserve'}">
                                <i class="fas fa-calendar-alt"></i>Reservations</router-link>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-users"></i>Users</a>
                        </li>
                       
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <a href="#">
                    <img :src="'../images/icon/iconlidts.png'" alt="Lindt's Food" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <router-link :to="{name:'admindashboard'}">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'food_category'}">
                                <i class="fas fa-list-alt"></i>Food Category
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'products'}">
                                <i class="fas fa-pencil-square"></i>Products</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'adminorder'}">
                                <i class="far fa-check-square"></i>Orders</router-link>
                        </li>
                        <li>
                            <router-link :to="{name:'adminreserve'}">
                                <i class="fas fa-calendar-alt"></i>Reservations</router-link>
                        </li>
                        <li>
                            <a href="map.html">
                                <i class="fas fa-users"></i>Users</a>
                        </li>
                        
                        
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            <form class="form-header" action="" method="POST">
                                <input class="au-input au-input--xl" type="text" name="search" placeholder="Search for datas &amp; reports..." />
                                <button class="au-btn--submit" type="submit">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </form>
                            <div class="header-button">
                                <div class="noti-wrap">
                                    <!-- <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-comment-more"></i>
                                        <span class="quantity">1</span>
                                        <div class="mess-dropdown js-dropdown">
                                            <div class="mess__title">
                                                <p>You have 2 news message</p>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Michelle Moreno" />
                                                </div>
                                                <div class="content">
                                                    <h6>Michelle Moreno</h6>
                                                    <p>Have sent a photo</p>
                                                    <span class="time">3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="mess__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Diane Myers" />
                                                </div>
                                                <div class="content">
                                                    <h6>Diane Myers</h6>
                                                    <p>You are now connected on message</p>
                                                    <span class="time">Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="mess__footer">
                                                <a href="#">View all messages</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-email"></i>
                                        <span class="quantity">1</span>
                                        <div class="email-dropdown js-dropdown">
                                            <div class="email__title">
                                                <p>You have 3 New Emails</p>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-06.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, 3 min ago</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-05.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, Yesterday</span>
                                                </div>
                                            </div>
                                            <div class="email__item">
                                                <div class="image img-cir img-40">
                                                    <img src="images/icon/avatar-04.jpg" alt="Cynthia Harvey" />
                                                </div>
                                                <div class="content">
                                                    <p>Meeting about new dashboard...</p>
                                                    <span>Cynthia Harvey, April 12,,2018</span>
                                                </div>
                                            </div>
                                            <div class="email__footer">
                                                <a href="#">See all emails</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="noti__item js-item-menu">
                                        <i class="zmdi zmdi-notifications"></i>
                                        <span class="quantity">3</span>
                                        <div class="notifi-dropdown js-dropdown">
                                            <div class="notifi__title">
                                                <p>You have 3 Notifications</p>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c1 img-cir img-40">
                                                    <i class="zmdi zmdi-email-open"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a email notification</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c2 img-cir img-40">
                                                    <i class="zmdi zmdi-account-box"></i>
                                                </div>
                                                <div class="content">
                                                    <p>Your account has been blocked</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__item">
                                                <div class="bg-c3 img-cir img-40">
                                                    <i class="zmdi zmdi-file-text"></i>
                                                </div>
                                                <div class="content">
                                                    <p>You got a new file</p>
                                                    <span class="date">April 12, 2018 06:50</span>
                                                </div>
                                            </div>
                                            <div class="notifi__footer">
                                                <a href="#">All notifications</a>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="account-wrap">
                                    <div class="account-item clearfix js-item-menu">
                                        <div class="image">
                                            <img :src="'/../images/icon/profile.png'"  />
                                        </div>
                                        <div class="content">
                                            <a class="js-acc-btn" href="#">john doe</a>
                                        </div>
                                        <div class="account-dropdown js-dropdown">
                                            <div class="info clearfix">
                                                <div class="image">
                                                    <a href="#">
                                                        <img :src="'/../images/icon/profile.png'"  />
                                                    </a>
                                                </div>
                                                <div class="content">
                                                    <h5 class="name">
                                                        <a href="#">{{ user.first_name }} {{ user.middle_name }} {{ user.last_name }}</a>
                                                    </h5>
                                                    <span class="email">{{ user.email }}</span>
                                                </div>
                                            </div>
                                            <div class="account-dropdown__body">
                                                <div class="account-dropdown__item">
                                                    <router-link :to="{name:'account'}">
                                                        <i class="zmdi zmdi-account"></i>Account</router-link>
                                                </div>
                                                <div class="account-dropdown__item">
                                                    <router-link :to="{name:'settings'}">
                                                        <i class="zmdi zmdi-settings"></i>Setting</router-link>
                                                </div>
                                                <!-- <div class="account-dropdown__item">
                                                    <a href="#">
                                                        <i class="zmdi zmdi-money-box"></i>Billing</a>
                                                </div> -->
                                            </div>
                                            <div class="account-dropdown__footer">
                                                <a href="#" @click="logout()">
                                                    <i class="zmdi zmdi-power"></i>Logout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <flashmessage :message="message" :status="status"></flashmessage>
            <router-view @show="flashMessage"></router-view>
             
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
        </div>

    </div>
</template>

<script>
import FlashMessage from '../page/FlashMessage.vue';
export default {
    components:{
        flashmessage: FlashMessage,
    },
    mounted() {
        // this.$router.push({name:"admindashboard"});

        let user = window.Laravel.user;
        this.user = user;
        try {
            var menu = $('.js-item-menu');
            var sub_menu_is_showed = -1;

            for (var i = 0; i < menu.length; i++) {
            $(menu[i]).on('click', function (e) {
                e.preventDefault();
                $('.js-right-sidebar').removeClass("show-sidebar");        
                if (jQuery.inArray(this, menu) == sub_menu_is_showed) {
                $(this).toggleClass('show-dropdown');
                sub_menu_is_showed = -1;
                }
                else {
                for (var i = 0; i < menu.length; i++) {
                    $(menu[i]).removeClass("show-dropdown");
                }
                $(this).toggleClass('show-dropdown');
                sub_menu_is_showed = jQuery.inArray(this, menu);
                }
            });
            }
            $(".js-item-menu, .js-dropdown").click(function (event) {
            event.stopPropagation();
            });

            $("body,html").on("click", function () {
            for (var i = 0; i < menu.length; i++) {
                menu[i].classList.remove("show-dropdown");
            }
            sub_menu_is_showed = -1;
            });

        } catch (error) {
            console.log(error);
        }


        
        var wW = $(window).width();
            // Right Sidebar
            var right_sidebar = $('.js-right-sidebar');
            var sidebar_btn = $('.js-sidebar-btn');

            sidebar_btn.on('click', function (e) {
            e.preventDefault();
            for (var i = 0; i < menu.length; i++) {
                menu[i].classList.remove("show-dropdown");
            }
            sub_menu_is_showed = -1;
            right_sidebar.toggleClass("show-sidebar");
            });

            $(".js-right-sidebar, .js-sidebar-btn").click(function (event) {
            event.stopPropagation();
            });

            $("body,html").on("click", function () {
            right_sidebar.removeClass("show-sidebar");

            });
        

        // Sublist Sidebar
        try {
            var arrow = $('.js-arrow');
            arrow.each(function () {
            var that = $(this);
            that.on('click', function (e) {
                e.preventDefault();
                that.find(".arrow").toggleClass("up");
                that.toggleClass("open");
                that.parent().find('.js-sub-list').slideToggle("250");
            });
            });

        } catch (error) {
            console.log(error);
        }


        try {
            // Hamburger Menu
            $('.hamburger').on('click', function () {
            $(this).toggleClass('is-active');
            $('.navbar-mobile').slideToggle('500');
            });
            $('.navbar-mobile__list li.has-dropdown > a').on('click', function () {
            var dropdown = $(this).siblings('ul.navbar-mobile__dropdown');
            $(this).toggleClass('active');
            $(dropdown).slideToggle('500');
            return false;
            });
        } catch (error) {
            console.log(error);
        }
    },
    data(){
        return{
            message:'',
            status:0,
            user:{},
        }
    },
    methods: {
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
    },


}
</script>

<style>

</style>
