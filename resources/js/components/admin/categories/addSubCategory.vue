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
                            <h5 class="text-dark" v-if="this.subCategoryForm.subCategoryGenId == ''">Add New Sub Category</h5>
                            <h5 class="text-dark" v-else>Edit Sub Category</h5>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header py-2">
                            <p class="text-primary m-0 fw-bold">Sub Category Info</p>
                        </div>
                        <form @submit.prevent="saveSubCategory()">
                             <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Category Name:&nbsp;</label>
                                        <select class="form-control form-control-sm" v-model="subCategoryForm.categoryId">
                                            <option value="">--Select--</option>
                                            <option :value="cat.id" v-for="(cat,index) in allCategory" :key="index"> {{cat.categoryName}}</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-sm-6 col-md-6 col-xl-4 text-nowrap mb-4">
                                        <label class="form-label">Sub Category Name:&nbsp;</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Type here..." v-model="subCategoryForm.subCategoryName">
                                    </div>
                                    
                                    <div class="col-12 col-sm-6 col-md-6 col-xl-2 text-nowrap mb-3">
                                        <label class="form-label">Status</label>
                                        <select class="form-control form-control-sm" v-model="subCategoryForm.status">
                                            <option value="">--Select--</option>
                                            <option value="1">Active</option>
                                            <option value="0">In-active</option>
                                        </select>
                                    </div>
                                </div>
                             </div>

                             <div class="card-footer">
                                <div class="col-12 col-sm-3 col-md-12 col-xl-2 text-nowrap">
                                    <button class="btn btn-danger btn-sm w-100" type="reset" v-if="this.subCategoryForm.subCategoryGenId == ''"><i class="fas fa-times-circle"></i>&nbsp;Reset</button>
                                    <router-link class="btn btn-danger btn-sm w-100" to="/admin/manage-categories" v-else><i class="fas fa-arrow-left"></i>&nbsp;Back</router-link>
                                    <button class="btn btn-sm w-100 ml-3" :class="this.subCategoryForm.subCategoryGenId == '' ? 'btn-primary':'btn-success'" type="submit"><i class="fas fa-check-circle"></i>&nbsp;{{this.subCategoryForm.subCategoryGenId == '' ? 'Save Chnages':'Update'}}</button>
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
            
            allCategory: {},
            subCategoryForm:{
                id               : '',
                categoryId       : '',
                subCategoryGenId : '',
                subCategoryName  : '',
                status           : '1'
            }
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

          saveSubCategory()
          {
            if(this.subCategoryForm.subCategoryGenId != '')
            {
                Api().post('/admin/update-sub-category/'+this.subCategoryForm.subCategoryGenId,this.subCategoryForm)
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
                        this.$router.push('/admin/manage-sub-categories');
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
            else
            {
                Api().post('/admin/add-sub-category',this.subCategoryForm)
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
                        this.$router.push('/admin/manage-sub-categories');
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

          async editSubCategory()
          {
            const subCategoryGenId = window.location.pathname.split('/').reverse()[0];

            Api().get('/admin/edit-sub-category/'+subCategoryGenId)
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
                if(response.data != '')
                { 
                    this.subCategoryForm = 
                    {
                        id               : response.data.id,
                        categoryId       : response.data.categoryId,
                        subCategoryGenId : response.data.subCategoryGenId,
                        subCategoryName  : response.data.subCategoryName,
                        status           : response.data.status
                    };
                }
            });
          }
       },
       created(){
        this.checkGuard();
        this.getCategoryDetails();
        this.editSubCategory();
       }
   }
</script>