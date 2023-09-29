<template>
    <div class="container">

<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form class="user" @submit.prevent="register()">
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control form-control-user" id="exampleFirstName"
                                placeholder="Name" v-model="registerForm.name">
                            </div>
                            
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control form-control-user" id="exampleInputEmail"
                                placeholder="Email Address" v-model="registerForm.email">
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="password" class="form-control form-control-user"
                                    id="exampleInputPassword" placeholder="Password" v-model="registerForm.password">
                            </div>
                            <div class="col-sm-6">
                                <input type="password" class="form-control form-control-user"
                                    id="exampleRepeatPassword" placeholder="Repeat Password" v-model="registerForm.c_password"> 
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Register Account
                        </button>
                        
                      
                    </form>
                    <hr>
                    
                    <div class="text-center">
                        <router-link class="small" to="/login">Already have an account? Login!</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</template>

<script>
import axios from 'axios';

export default {
    data(){
        return{
             registerForm:{
                name       :'',
                email      :'',
                password   :'',
                c_password :''
              }, 
            }
    },

    methods:{
        register()
        {
                axios.post('/api/admin/register/',this.registerForm)
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
                }).then((response) =>{
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
                        this.$router.push('/admin/login');
                       
                    }
                    if(response.data['success'] == false)
                    {
                        this.$swal({
                            icon: 'error',
                            title: ' '+response.data['message'],
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 4000
                        });
                    }
                });
        }
    },
}
</script>