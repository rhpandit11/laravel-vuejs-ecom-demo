<template>
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" :class="isToggled == false? 'toggled':''">
       <div class="container-fluid d-flex flex-column p-0">
           <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
               <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-laugh-wink"></i></div>
               <div class="sidebar-brand-text mx-3">E-Commerce</div>
           </a>
           <hr class="sidebar-divider my-0">
           <ul class="navbar-nav text-light" id="accordionSidebar">
               <li class="nav-item"><router-link class="nav-link" to="/admin"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></router-link></li>
               <li class="nav-item"><router-link class="nav-link" to="/admin/manage-categories"><i class="fa fa-bars"></i><span>Categories</span></router-link></li>
               <li class="nav-item"><router-link class="nav-link" to="/admin/manage-sub-categories"><i class="fa fa-list-alt"></i><span>Sub Categories</span></router-link></li>
                <li class="nav-item"><router-link class="nav-link" to="/admin/manage-products"><i class="fa fa-shopping-bag"></i><span>Products</span></router-link></li>
           </ul>
           <div class="text-center d-none d-md-inline">
               <button class="btn rounded-circle border-0" id="sidebarToggle" type="button" @click="toggleSidebar()"></button>
           </div>
       </div>
    </nav>
</template>

<script>
import Api      from '../../src/Api.js';
import Chokidar from '../../src/Chokidar.js';
export default {
   data(){
       return{
           isToggled : false,
           guards:''
       }
   },
   methods:{
       toggleSidebar(){
         this.isToggled = !this.isToggled;
       },
        checkGuard()
        {
            let guard = Chokidar(); 
            if(guard == 'web' ){

            }else{
                this.$router.push('/admin/login');
            }
        }
   },

   created()
   {
       this.$eventBus.on('isToggled', (toggle) => {
           if(toggle == true){
            this.isToggled = true
           }else{
            this.isToggled = false;
           }
       });

       this.checkGuard();
   }
};
</script>