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

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
            </div>

            <!-- Content Row -->
            <div class="row">

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Categories </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.dashboard.totalCategories }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-shopping-cart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Sub Categories </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.dashboard.totalSubCategories }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-shopping-cart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Products </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ this.dashboard.totalProducts }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fa-shopping-cart fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                
            </div>

          
        </div>
        <!-- /.container-fluid -->

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

import Sidebar  from '../../layouts/admin/sidebar.vue';
import Navabr   from '../../layouts/admin/navbar.vue';
import Footer   from '../../layouts/admin/footer.vue';
import Chokidar from '../../src/Chokidar.js';
import Api      from '../../src/Api.js';

   export default {
       components:{
           sidebar :Sidebar,
           navbar  :Navabr,
           footers :Footer    
       },
       data(){
        return{
            dashboard:
            {
              totalCategories    : 0,
              totalSubCategories : 0,
              totalProducts      : 0
            },
         }
       },
       methods:{
          checkGuard()
          {
            let guard     = Chokidar(); 
            if(guard == 'web' ){

            }else{
                this.$router.push('/admin/login');
            }
            
          },

          async getAllCount()
          {
                Api().get('/admin/count-dashboard')
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
                            this.dashboard = {
                                totalCategories    : response.data.totalCategories,
                                totalSubCategories : response.data.totalSubCategories,
                                totalProducts      : response.data.totalProducts
                            }
                        }
                });

          },

       },
       created()
       {
        this.checkGuard();
        this.getAllCount();
       }
   }
</script>