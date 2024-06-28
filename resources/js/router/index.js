import { createRouter, createWebHistory } from "vue-router";

import login from  '../Components/login.vue'
import notFound from '../Components/notFound.vue'
import dashboard from '../Components/dashboard.vue'
// import businessunit_index from '../Components/businessunit/index.vue'
// import businessunit_new from '../Components/businessunit/new.vue'
// import businessunit_edit from '../Components/businessunit/edit.vue'
// import department_index from '../Components/department/index.vue'
// import department_new from '../Components/department/new.vue'
// import department_edit from '../Components/department/edit.vue'
// import documenttype_index from '../Components/document_type/index.vue'
// import documenttype_new from '../Components/document_type/new.vue'
// import documenttype_edit from '../Components/document_type/edit.vue'
// import filing_new from '../Components/filing/new.vue'
// import filing_view from '../Components/filing/view.vue'
// import drafts from '../Components/filing/drafts.vue'
// import filing_list from '../Components/filing/list.vue'
const routes = [

    {
        path:'/',
        name:'login',
        component: login,
        meta:{
            requiresAuth:false
        }
    },
    {
        path:'/dashboard',
        component: dashboard,
        meta:{
            requiresAuth:true
        }
    },
    // {
    //     path:'/businessunit_list',
    //     component: businessunit_index,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/businessunit_new',
    //     component: businessunit_new,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/businessunit_edit/:id',
    //     component: businessunit_edit,
    //     props:true,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/department_list',
    //     component: department_index,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/department_new',
    //     component: department_new,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/department_edit/:id',
    //     component: department_edit,
    //     props:true,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/documenttype_list',
    //     component: documenttype_index,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/documenttype_new',
    //     component: documenttype_new,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/documenttype_edit/:id',
    //     component: documenttype_edit,
    //     props:true,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/filing_new/:id',
    //     component: filing_new,
    //     props:true,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/filing_view/:id',
    //     component: filing_view,
    //     props:true,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/drafts',
    //     component: drafts,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
    // {
    //     path:'/filing_list',
    //     component: filing_list,
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
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

router.beforeEach((to,from) => {
    if(to.meta.requiresAuth && !localStorage.getItem('token')){
        return { name: 'login'}
    }
})


export default router