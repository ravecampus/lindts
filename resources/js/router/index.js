import {createWebHistory, createRouter} from "vue-router";
import Home from '../page/Home';
import Menu from '../page/Menu';
import Dashboard from '../page/Dashboard';
import Signup from '../page/Signup';
import Signin from '../page/Signin';
import Admin from '../admin/Main';
import FoodCategory from '../admin/FoodCategory';
import Products from '../admin/Product';


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
                path:'food-category',
                name:'food_category',
                component: FoodCategory  
            },
            {
                path:'products',
                name:'products',
                component: Products  
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
    'menu'
   
];

const userRoutes = [
    'home',
   
];
const adminRoutes = [
    'admin',
    'food_category',
    'products'
    
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