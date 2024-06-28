import { createRouter, createWebHistory } from "vue-router";

import login from  '../Components/login.vue'
import notFound from '../Components/notFound.vue'
import dashboard from '../Components/dashboard.vue'
import add_new from '../Components/book/new.vue'
import edit_book from '../Components/book/update.vue'
const routes = [

   
    {
        path:'/',
        component: dashboard,
      
    },

    {
        path:'/add_book',
        component: add_new,
      
    },
    {
        path:'/update_book/:id',
        component: edit_book,
        props:true
      
    },
   
    {
        path:'/:pathMatch(.*)*',
        name:'notFound',
        component: notFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// router.beforeEach((to,from) => {
//     if(to.meta.requiresAuth && !localStorage.getItem('token')){
//         return { name: 'login'}
//     }
// })


export default router