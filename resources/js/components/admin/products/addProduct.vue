<template>
    <!-- Page Wrapper -->
    <div id="wrapper">

    <!-- Sidebar -->
    <sidebar />
   

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Navbar -->
        <navbar />

        <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-12 col-xl-4">
                            <h5 class="text-dark" v-if="this.productForm.productGenId == ''">Add New Product</h5>
                            <h5 class="text-dark" v-else>Edit Product</h5>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-2">
                            <p class="text-primary m-0 fw-bold">Product Info</p>
                        </div>
                        <form @submit.prevent="saveProduct()">
                             <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Category Name:&nbsp;</label>
                                        <select class="form-control form-control-sm" v-model="productForm.categoryId" @change="getSubCategories($event)">
                                            <option value="">--Select--</option>
                                            <option :value="cat.id" v-for="(cat,index) in allCategory" :key="index"> {{cat.categoryName}}</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Sub-Category Name:&nbsp;</label>
                                        <select class="form-control form-control-sm" v-model="productForm.subCategoryId">
                                            <option value="">--Select--</option>
                                            <option :value="subcat.id" v-for="(subcat,index) in allSubCategory" :key="index"> {{subcat.subCategoryName}}</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Brand Name:&nbsp;</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Type here..." v-model="productForm.productBrandName">
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Product Name:&nbsp;</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Type here..." v-model="productForm.productName">
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Product Price:&nbsp;</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Type here..." v-model="productForm.productPrice">
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Product Image:&nbsp;</label>
                                        <input class="form-control form-control-sm" type="file" ref="productImageFile" @change="selectProductImage()">
                                        <img class="mt-1" :src="showProductImg" alt="" width="200" height="200">
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-xl-2 text-nowrap mb-3">
                                        <label class="form-label">Stock Status</label>
                                        <select class="form-control form-control-sm" v-model="productForm.stockStatus">
                                            <option value="">--Select--</option>
                                            <option value="1">In Stock</option>
                                            <option value="0">Out of Stock</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-2 text-nowrap mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-control form-control-sm" v-model="productForm.status">
                                            <option value="">--Select--</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-active</option>
                                        </select>
                                    </div>
                                </div>
                             </div>

                             <div class="card-footer">
                                <div class="col-12 col-sm-3 col-md-12 col-xl-2 text-nowrap">
                                    <button class="btn btn-danger btn-sm w-100" type="reset" v-if="this.productForm.productGenId == ''"><i class="fas fa-times-circle"></i>&nbsp;Reset</button>
                                    <router-link class="btn btn-danger btn-sm w-100" to="/admin/manage-products" v-else><i class="fas fa-arrow-left"></i>&nbsp;Back</router-link>
                                    <button class="btn btn-sm w-100 ml-3" :class="this.productForm.productGenId == '' ? 'btn-primary':'btn-success'" type="submit"><i class="fas fa-check-circle"></i>&nbsp;{{this.productForm.productGenId == '' ? 'Save Changes':'Update'}}</button>
                                </div>
                               
                             </div>
                        </form>
                    </div>
                </div>

          </div>
    <!-- End of Main Content -->

    <!-- footer -->
    <footers />

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
</template>

<script>

import Sidebar  from '../../../layouts/admin/sidebar.vue';
import Navabr   from '../../../layouts/admin/navbar.vue';
import Footer   from '../../../layouts/admin/footer.vue';
import Chokidar from '../../../src/Chokidar.js';
import Api      from '../../../src/Api.js';

   export default {
       components:{
           sidebar :Sidebar,
           navbar  :Navabr,
           footers :Footer    
       },
       data(){
        return{
            allCategory:    {}, //getting category data in product form 
            allSubCategory: {}, //getting subcategory data in product form

            productForm:{
                id                : '',
                productGenId      : '',
                productBrandName  : '',
                productName       : '',
                productImageFile  : '',
                productImageName  : '',
                productPrice      : '',
                categoryId        : '',
                subCategoryId     : '',
                status            : '1',
                stockStatus       : '1'
            },
            showProductImg :''
        }
       },
       methods:{
            checkGuard()
            {
                let guard = Chokidar(); 
                if(guard == 'web' ){

                }else{
                    this.$router.push('/admin/login');
                }
            },

            getCategoryDetails()
            {
                    Api().get('/admin/get-all-categories/')
                        .catch((error) => {
                        if (error.response.status == 401) {
                            localStorage.removeItem('token');
                            localStorage.removeItem('guard');
                            this.$swal({
                            icon: 'error',
                            title: 'Session Expired please login!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000
                            });
                            this.$router.push('/admin/login');
                        } 
                    }).then((response) => {
                        if(response.data != ''){ 
                        this.allCategory = response.data;
                        }
                    });
            },

            //File upload encrypted format base64 
            selectProductImage()
            {
                let file = this.$refs.productImageFile.files[0];
                if(file.type == 'image/jpeg' || file.type =='image/jpg' || file.type =='image/png')
                { 
                    if(file.size > 1024 * 1024) 
                    {
                    //this.$refs[index][0].files[0] ='';
                        // e.preventDefault();
                        this.$swal({
                                icon: 'warning',
                                title: "Image is Too Large - Max 1 MB each",
                                position: 'top-end',
                                toast: true,
                                showConfirmButton: false,
                                timer: 4000
                            })
                            
                        return
                    }else
                    {
                        let fileName = file.name;
                        let fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        fileReader.onload = (e) => {
                            this.productForm.productImageFile = e.target.result;
                            this.showProductImg               = e.target.result;
                        }
                        this.productForm.productImageName = fileName;
                    }
                }else{
                    this.$swal({
                        icon: 'warning',
                        title: "png,jpeg or jpg files only!",
                        position: 'top-end',
                        toast: true,
                        showConfirmButton: false,
                        timer: 4000
                    }) 
                }
            },
            // Update Categories  
            saveProduct()
            {
                if(this.productForm.productGenId != '')
                {
                    Api().post('/admin/update-product/'+this.productForm.productGenId,this.productForm)
                        .catch((error) => {
                            if (error.response.status == 401) {
                                localStorage.removeItem('token');
                                localStorage.removeItem('guard');
                                this.$swal({
                                icon: 'error',
                                title: 'Session Expired please login!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                            });
                                this.$router.push('/admn/login');
                            } 
                        }).then((response) => {
                        if(response.data['success'] == true)
                        {
                            this.$swal({
                                icon: 'success',
                                title: ' '+response.data['msg'],
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                            });
                            this.$router.push('/admin/manage-products');
                        }

                        if(response.data['success'] == false)
                        {
                            this.$swal({
                                icon: 'error',
                                title: ' '+response.data['msg'],
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                            });
                        
                        }
                    });
                }
                // Add Categories
                else
                {
                    Api().post('/admin/add-product',this.productForm)
                        .catch((error) => {
                        if (error.response.status == 401) {
                            localStorage.removeItem('token');
                            localStorage.removeItem('guard');
                            this.$swal({
                            icon: 'error',
                            title: 'Session Expired please login!',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000
                        });
                            this.$router.push('/admin/login');
                        } 
                    }).then((response) => {
                        if(response.data['success'] == true)
                        {
                            this.$swal({
                                icon: 'success',
                                title: ' '+response.data['msg'],
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                            });
                            this.$router.push('/admin/manage-products');
                        }

                        if(response.data['success'] == false)
                        {
                            this.$swal({
                                icon: 'error',
                                title: ' '+response.data['msg'],
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                            });
                        }
                    });
                }
            },

        // single record  Edit Products
            async editProduct()
            {
                const productGenId = window.location.pathname.split('/').reverse()[0];

                Api().get('/admin/edit-product/'+productGenId)
                     .catch((error) => {
                    if (error.response.status == 401) {
                        localStorage.removeItem('token');
                        localStorage.removeItem('guard');
                        this.$swal({
                        icon: 'error',
                        title: 'Session Expired please login!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 4000
                        });
                        this.$router.push('/admin/login');
                    } 
                }).then((response) => {
                    if(response.data.length != '')
                    { 
                        this.productForm = 
                        {
                            id                : response.data.id,
                            productGenId      : response.data.productGenId,
                            productBrandName  : response.data.productBrandName,
                            productName       : response.data.productName,
                            productPrice      : response.data.productPrice,
                            categoryId        : response.data.categoryId,
                            subCategoryId     : response.data.subCategoryId,
                            status            : response.data.status,
                            stockStatus       : response.data.stockStatus
                        };
                        this.showProductImg = response.data.fileURL;
                        this.getSubCategoriesForEdit(response.data.categoryId);
                    }
                });
            },

             // category wise Subcategory selection in product from
            getSubCategories(event)
            {
                if(event.target.value != ''){
                        Api().get('/admin/get-all-sub-categories/'+event.target.value)
                                .catch((error) => {
                            if (error.response.status == 401) {
                                localStorage.removeItem('token');
                                localStorage.removeItem('guard');
                                this.$swal({
                                icon: 'error',
                                title: 'Session Expired please login!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                                });
                                this.$router.push('/admin/login');
                            } 
                    }).then((response) => {
                        if(response.data != ''){ 
                          this.allSubCategory = response.data;
                        }
                    });
                }
            },

            getSubCategoriesForEdit(categoryId)
            {
                        Api().get('/admin/get-all-sub-categories/'+categoryId)
                             .catch((error) => {
                            if (error.response.status == 401) {
                                localStorage.removeItem('token');
                                localStorage.removeItem('guard');
                                this.$swal({
                                icon: 'error',
                                title: 'Session Expired please login!',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 4000
                                });
                                this.$router.push('/admin/login');
                            } 
                    }).then((response) => {
                        if(response.data != ''){ 
                          this.allSubCategory = response.data;
                        }
                    });
                
            },
       },
       created()
       {
        this.checkGuard();
        this.getCategoryDetails();
        this.editProduct();
       }
   }
</script>