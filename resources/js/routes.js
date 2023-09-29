import {createRouter,createWebHistory} from 'vue-router';

import Register            from './components/admin/auth/register.vue';
import Login               from './components/admin/auth/login.vue';
import Index               from './components/admin/index.vue';
import AddCategory         from './components/admin/categories/addCategory.vue';
import ManageCategories    from './components/admin/categories/manageCategories.vue';
import AddSubCategory      from './components/admin/categories/addSubCategory.vue';
import ManageSubCategories from './components/admin/categories/manageSubCategories.vue';
import AddProduct          from './components/admin/products/addProduct.vue';
import ManageProducts      from './components/admin/products/manageProducts.vue';


// USER SECTION
import HomePage            from './components/homePage.vue';
import ViewProduct         from './components/viewProduct.vue';

const routes = [
    {
        path     : '/admin/register',
        component:  Register,
        name     : "register"
    },
    {
        path     : '/admin/login',
        component:  Login,
        name     : "login"
    },
    {
        path     : '/admin',
        component: Index,
        name     : "index"
    },
    {
        path     : '/admin/add-category',
        component:  AddCategory,
        name     : "add-category"
    },
    {
        path     : '/admin/edit-category/:categoryGenId',
        component:  AddCategory,
        name     : "edit-category"
    },
    {
        path     : '/admin/manage-categories',
        component:  ManageCategories,
        name     : "manage-categories"
    },
    {
        path     : '/admin/add-sub-category',
        component:  AddSubCategory,
        name     : "add-sub-category"
    },
    {
        path     : '/admin/manage-sub-categories',
        component:  ManageSubCategories,
        name     : "manage-sub-categories"
    },
    {
        path     : '/admin/edit-sub-category/:subCategoryGenId',
        component:  AddSubCategory,
        name     : "edit-sub-category"
    },
    {
        path     : '/admin/add-product',
        component:  AddProduct,
        name     : "add-product"
    },
    {
        path     : '/admin/manage-products',
        component:  ManageProducts,
        name     : "manage-products"
    },
    {
        path     : '/admin/edit-product/:productId',
        component:  AddProduct,
        name     : "edit-product"
    },
    {
        path     : '/',
        component:  HomePage,
        name     : "homePage"
    },
    {
        path     : '/view-product/:token',
        component:  ViewProduct,
        name     : "view-product"
    },
]


export default createRouter({
    history: createWebHistory(),
    routes
});