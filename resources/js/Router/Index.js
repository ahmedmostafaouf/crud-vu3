import { createRouter, createWebHistory } from 'vue-router';
import Home from '../Pages/Home.vue'
import Login from '../Pages/Auth/Login.vue'
import Register from '../Pages/Auth/Register.vue'
import Dashboard from '../Pages/Dashboard.vue'
import Users from '../Components/Users/Index.vue'
import EditUser from '../Components/Users/EditUser.vue'
import CreateUser from '../Components/Users/CreateUser.vue'

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
        meta:{
            middleware:"guest",
            title:`Home`
        }
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta:{
            middleware:"auth",
            title:`Home`
        }
    },
    {
        path: '/users',
        name: 'users',
        component: Users,
        meta:{
            middleware:"auth",
            title:`Users`
        }
    },
    {
        path: '/user/edit/:id',
        name: 'edit_user',
        component: EditUser,
        meta:{
            middleware:"auth",
            title:`Edit User`
        }
    },
    {
        path: '/user/create',
        name: 'create_user',
        component: CreateUser,
        meta:{
            middleware:"auth",
            title:`Create User`
        }
    },
    {
        path: '/login',
        name: 'Login',
        component: Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }

    },
    {
        path: '/register',
        name: 'Register',
        component: Register,
        meta:{
            middleware:"guest",
            title:`Register`
        }
    },
]
const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title}`
    if(to.meta.middleware=="guest"){
        if(localStorage.getItem('authenticated')){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(localStorage.getItem('authenticated')){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router
