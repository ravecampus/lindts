import {createWebHistory, createRouter} from "vue-router";
import Home from '../page/Home';
import Menu from '../page/Menu';
import Payment from '../page/Payment';
import PaymentReserve from '../page/PaymentReserve';
import PaymentReserveSuccess from '../page/PaymentReserveSuccess';
import PaymentSuccess from '../page/PaymentSuccess';
import Myorder from '../page/MyOrder';
import MyProfile from '../page/MyProfile';
import Reservation from '../page/Reservation';
import Slip from '../page/Slip';
import Dashboard from '../page/Dashboard';
import Signup from '../page/Signup';
import Signin from '../page/Signin';
import Admin from '../admin/Main';
import Adashboard from '../admin/AdminDashboard';
import FoodCategory from '../admin/FoodCategory';
import Products from '../admin/Product';
import Settings from '../admin/Setting';
import AdminOrder from '../admin/AdminOrder';
import AdminReserve from '../admin/AdminReservation';
import AdminProfile from '../admin/AdminProfile';
import AdminUser from '../admin/AdminUser';
import AdminClient from '../admin/AdminClient';
import AdminReport from '../admin/Report';
import AdminReport1 from '../admin/Report1';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home,
        children:[
            {
                path:'/',
                name:'dashboard',
                component: Dashboard  
            },
            {
                path:'menu',
                name:'menu',
                component: Menu  
            },
            {
                path:'payment',
                name:'payment',
                component:Payment
            },
            {
                path:'payment/success',
                name:'paymentsuccess',
                component:PaymentSuccess
            },
            {
                path:'slip',
                name:'slip',
                component:Slip
            },
            {
                path:'my-orders',
                name:'myorder',
                component:Myorder
            },
            {
                path:'my-profile',
                name:'myprofile',
                component:MyProfile
            },
            {
                path:'reservation',
                name:'reservation',
                component:Reservation
            },
            {
                path:'payment-reserve',
                name:'payreserve',
                component:PaymentReserve
            },
            {
                path:'payreserve-success',
                name:'payreservesuccess',
                component:PaymentReserveSuccess
            },
           
        ]

    },
    {
        name: 'signup',
        path: '/signup',
        component: Signup,
    },
    {
        name: 'signin',
        path: '/signin',
        component: Signin,
    },
    {
        name: 'admin',
        path: '/admin',
        component: Admin,
        children:[
            {
                path:'',
                name:'admindashboard',
                component: Adashboard  
            },
            {
                path:'/food-category',
                name:'food_category',
                component: FoodCategory  
            },
            {
                path:'/products',
                name:'products',
                component: Products  
            },
            {
                path:'/settings',
                name:'settings',
                component: Settings  
            },
            {
                path:'/orders',
                name:'adminorder',
                component: AdminOrder  
            },
            {
                path:'/reservations',
                name:'adminreserve',
                component: AdminReserve  
            },
            {
                path:'/account',
                name:'account',
                component: AdminProfile  
            },
            {
                path:'/users',
                name:'adminuser',
                component: AdminUser 
            },
            {
                path:'/clients',
                name:'adminclient',
                component: AdminClient 
            },
            {
                path:'/orders-report',
                name:'adminreport',
                component: AdminReport 
            },
            {
                path:'/reservation-report',
                name:'adminreport1',
                component: AdminReport1
            }
        ]
    }
    

];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});
const openRoutes = [
    'signup', 
    'signin', 
    'home',
    'dashboard',
    'menu',
    'reservation',
    
   
];

const userRoutes = [
    'home',
    'payment',
    'paymentsuccess',
    'slip',
    'myorder',
    'myprofile',
    'payreserve',
    'payreservesuccess'
   
];
const adminRoutes = [
    'admin',
    'food_category',
    'products',
    'settings',
    'admindashboard',
    'adminorder',
    'adminreserve',
    'account',
    'adminuser',
    'adminclient',
    'adminreport',
    'adminreport1',
    
];


router.beforeEach((to, from, next)=>{
    if(!window.Laravel.isLoggedin){
        if(openRoutes.includes(to.name)){
            return next();
        }
    }else{
        let user = window.Laravel.user;
        if(adminRoutes.includes(to.name) && user.role == 1){
            return next();
        }else if(userRoutes.includes(to.name) && user.role == 0){
            return next();
        }
    }
    if(openRoutes.includes(to.name)){
        return next();
    }else{
        return next({name:'signin'});
    }
    
   
});

export default router;