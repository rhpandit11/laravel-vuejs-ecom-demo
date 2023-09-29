<template>
    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; SB ADMIN {{ new Date().getFullYear() }}</span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
</template>

<script>

import Chokidar from '../../src/Chokidar.js';
export default {
  data() {
        return{
            guards:''
        }
    },
    methods: {
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
        this.checkGuard();
    }
    
};

</script>