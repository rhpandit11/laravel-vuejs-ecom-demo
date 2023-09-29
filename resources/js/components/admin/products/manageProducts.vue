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
                    <h5 class="text-dark">Manage Products</h5>
                </div>
                <div class="col-12 col-xl-2 offset-xl-6 align-self-center offset-">
                    <router-link class="btn btn-primary btn-sm w-100" role="button" to="/admin/add-product">
                        <i class="fas fa-plus-circle"></i>&nbsp;Add New Product
                    </router-link>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header py-2">
                    <p class="text-primary m-0 fw-bold">Products  Info</p>
                </div>
                <div class="card-body">
                    <!-- <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 col-xl-2 text-nowrap top-search-col"><input type="text" class="form-control form-control-sm" placeholder="Search..."></div>
                        <div class="col-6 col-sm-6 col-md-6 col-xl-2 text-nowrap top-search-col"><input type="text" class="form-control form-control-sm" placeholder="Search..."></div>
                        <div class="col-6 col-sm-6 col-md-6 col-xl-2 text-nowrap top-search-col"><input type="text" class="form-control form-control-sm" placeholder="Search..."></div>
                        <div class="col-6 col-sm-6 col-md-6 col-xl-2 text-nowrap top-search-col"><input type="text" class="form-control form-control-sm" placeholder="Search..."></div>
                        <div class="col-6 col-sm-6 col-md-6 col-xl-2 text-nowrap top-search-col"><input type="text" class="form-control form-control-sm" placeholder="Search..."></div>
                        <div class="col-3 col-sm-3 col-md-6 col-xl-1 text-nowrap top-search-col"><button class="btn btn-dark btn-sm w-100"    type="button"><i class="fas fa-undo"></i></button></div>
                        <div class="col-3 col-sm-3 col-md-6 col-xl-1 text-nowrap top-search-col"><button class="btn btn-primary btn-sm w-100" type="button"><i class="fas fa-search"></i></button></div>
                    </div> -->
                    <div class="table-responsive text-nowrap table mt-2">
                        <table class="table table-sm my-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Product GEN ID</th>
                                    <th>Category Name</th>
                                    <th>Sub Category Name</th>
                                    <th>Brand Name</th>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Image</th>
                                    <th class="text-center">Stock Status</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pro,index) in allProducts" :key="index">
                                    <td>{{ pro.productGenId }}</td>
                                    <td>{{ pro.get_categories.categoryName }}</td>
                                    <td>{{ pro.get_sub_categories.subCategoryName }}</td>
                                    <td>{{ pro.productBrandName }}</td>
                                    <td>{{ pro.productName }}</td>
                                    <td>{{ parseInt(pro.productPrice).toLocaleString() }}</td>
                                    <td><img :src="pro.fileURL" height="80" width="90" /></td>
                                    
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-info" v-if="pro.stockStatus == 1">In Stock</span>
                                        <span class="badge rounded-pill bg-danger" v-else>Out of Stock</span>
                                    </td>
                                    
                                    <td class="text-center">
                                        <span class="badge rounded-pill bg-success" v-if="pro.status == 1">Active</span>
                                        <span class="badge rounded-pill bg-danger" v-else>In-active</span>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <button class="btn btn-primary btn-sm" aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside" type="button"><i class="fas fa-cog"></i></button>
                                            <div class="dropdown-menu">
                                                <router-link class="dropdown-item" :to="'/admin/edit-product/'+pro.productGenId"><i class="fas fa-pen"></i>&nbsp;Edit Product</router-link>
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" :data-bs-target="'#delPro'+index"><i class="fas fa-trash" ></i>&nbsp;Delete Product</a>
                                            </div>
                                        </div>

                                            <div class="modal fade" :id="'delPro'+index" style="background: rgba(0,0,0,0.5);" data-bs-backdrop="false" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Category ({{ pro.productName }})</h4>
                                                            <button class="btn-close" type="button" aria-label="Close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5>Are you sure want to delete ?</h5>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-dark"   type="button" data-bs-dismiss="modal">Close</button>
                                                            <button class="btn btn-danger" type="button"  @click="deleteProduct(pro.productGenId)" data-bs-dismiss="modal">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <!-- <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 5 of 30</p>
                        </div> -->
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                <ul class="pagination pagination-sm">
                                    <li class="page-item disabled"><a class="page-link" aria-label="Previous" href="#"><span aria-hidden="true">«</span></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" aria-label="Next" href="#"><span aria-hidden="true">»</span></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
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
            allProducts:{}
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
        
            async getAllProducts()
            {
                    Api().get('/admin/manage-products')
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
                                this.allProducts = response.data;
                            }
                    });

            },

            deleteProduct(productGenId)
            {
                Api().post('/admin/delete-product/'+productGenId)
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
                        this.getAllProducts();
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
                        this.getAllProducts();
                    }
                });
            },
       },
       created()
       {
        this.checkGuard();
        this.getAllProducts();
       }
   }
</script>