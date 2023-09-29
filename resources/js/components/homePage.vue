<template>
      <navbar/>

      
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <a class="nav-link mt-1" href="#"  data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-shopping-cart"></i> Cart ({{runningTotalQty}})
            </a>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-4">All Products</h4>
                </div>
               
                
                <div class="col-md-3" v-for="(data,index) in products" :key="index" >
                    <div class="product-card">
                        <div class="product-card-img">
                            <label class="stock" :class="data.stockStatus == 1 ? 'bg-success' : 'bg-danger'">{{ data.stockStatus == 1 ? 'In Stock' : 'Out of Stock' }}</label>
                            <img :src="data.fileURL" alt="" style="width: 200px; height: 300px;">
                        </div>
                        <div class="product-card-body">
                            <p class="product-brand">{{ data.productBrandName }}</p>
                            <h5 class="product-name">
                               <a href="">
                                {{ data.productName }}
                               </a>
                            </h5>
                            <div>
                                <span class="selling-price"> ₹ {{ data.productPrice.toLocaleString()}}</span>
                            </div>
                            <div class="mt-2">
                                <a href="#" class="btn btn1" :class="data.stockStatus == 0 ? 'disabled' : ''" @click="addToCart(data)">Add To Cart</a>
                                <a href="#" class="btn btn1"> <i class="fa fa-heart"></i>Wishlist </a>
                                <router-link :to="'/view-product/'+data.token" class="btn btn1"> View </router-link>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Cart Value : ₹ {{runningCartValue > 0 ? runningCartValue.toLocaleString() : ''}}</h5>
                <table class="table table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Product Price</th>
                        <th>Quantity</th>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in cartItems" :key="index">
                           <td> <img :src="item.fileURL" alt="" style="width: 80px; height: 80px;"></td>
                            <td>{{item.productName}}</td>
                            <td>{{item.productPrice > 0 ? item.productPrice.toLocaleString() : ''}}</td>
                            <td>
                                <button class="btn btn-success btn-sm" @click="increaseQuantity(item)">+</button>
                                    {{item.quantity}}
                                <button class="btn btn-danger btn-sm"  @click="decreaseQuantity(item)">-</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>₹ {{runningCartValue > 0 ?  runningCartValue.toLocaleString() : ''}}</td>
                            <td>  {{runningTotalQty > 0 ?  runningTotalQty : ''}}</td>
                        </tr>
                    </tfoot>
                </table>
             </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" @click="clearCart()">Clear Cart</button>
                </div>
            </div>
          </div>
        </div>
    
</template>


<script>

  import Navabr   from '../layouts/user/navbar.vue';
  import Footer   from '../layouts/user/footer.vue';
  import OpenApi  from '../src/OpenApi.js';

  export default {
       components:{
           navbar  :Navabr,
           footers :Footer 
       },
       data()
       {
            return {
                products      : [],
                allCategories : [],
                cartItems     : []
            }
       },
       methods: {
            // Getting all products table data
            getAllProducts()
            {
                OpenApi().get('/products')
                         .catch((error) => {
                    
                }).then((response) => {
                    if(response.data.length != '')
                    { 
                        this.products = response.data;
                    }
                });
            },
            //getting all Categories table data
            getAllCategories()
            {
                OpenApi().get('/get-all-categories')
                    .catch((error) => {
                    
                }).then((response) => {
                    if(response.data.length != '')
                    { 
                        this.allCategories = response.data;
                    }
                });
            },
            // add to cart by product table adding quantity increasing cart value
            addToCart(product) 
            {
                const existingItem = this.cartItems.find(item => item.id === product.id);
                if (existingItem) {
                  existingItem.quantity++;
                } else {
                  this.cartItems.push({ ...product, quantity: 1 });
                }
            },
            // clearing all cart data | and plus and minus button quantity increase and decrease
            clearCart() 
            {
              this.cartItems = [];
            },

            increaseQuantity(item) {
                item.quantity++;
            },
            decreaseQuantity(item) {
                if (item.quantity > 1) {
                 item.quantity--;
            }
          }
        },
        // cart product price calculation | Total Price
        computed:{
            runningCartValue()
            {
                let total = 0;
                this.cartItems.forEach(item => {
                        total = total + Number(item.productPrice * item.quantity);
                    });
                return total;
            },

            runningTotalQty()
            {
                let total = 0;
                this.cartItems.forEach(item => {
                      total = total + Number(item.quantity);
                    });
                return total;
            }
        },

       created() 
       {
        this.getAllCategories();
        this.getAllProducts();
       },

               


      }

</script>