<template>
    <navbar/>
    
    <div class="py-3 py-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-5 mt-3">
                    <div class="bg-white border">
                        <img :src="productImg" class="w-100" alt="Img">
                    </div>
                </div>
                <div class="col-md-7 mt-3">
                    <div class="product-view">
                        <h4 class="product-name">
                            {{product.productName}}
                            <label class="label-stock" :class="product.stockStatus == 1 ? 'bg-success' : 'bg-danger'">{{product.stockStatus == 1 ? 'In Stock' : 'Out of Stock' }}</label>
                        </h4>
                        <hr>
                      
                        <div>
                            <span class="selling-price"> ₹ {{ product.productPrice.toLocaleString()}}</span>
                        </div>
                        <div class="mt-2">
                            <div class="input-group">
                                <span class="btn btn1"><i class="fa fa-minus"></i></span>
                                <input type="text" value="1" class="input-quantity" />
                                <span class="btn btn1"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a  href="" :class="product.stockStatus == 0 ? 'disabled' : ''" class="btn btn1"> <i class="fa fa-shopping-cart"></i> Add To Cart</a>
                            <a  href="" class="btn btn1"> <i class="fa fa-heart"></i> Add To Wishlist </a>
                        </div>
                        
                    </div>
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
       data(){
        return{
            product:{
                id                : '',
                productGenId      : '',
                productBrandName  : '',
                productName       : '',
                productPrice      : '',
                categoryId        : '',
                subCategoryId     : '',
                status            : '',
                stockStatus       : ''
            },
            productImg : ''
         }
       },
       methods: {
            getAProduct()
            {
                const token = window.location.pathname.split('/').reverse()[0];

                OpenApi().get('/view-product/'+token)
                         .catch((error) => {
                    
                }).then((response) => {
                    if(response.data.length != '')
                    { 
                        this.product = 
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
                        this.productImg = response.data.fileURL;
                    }
                });
            }
        },

        created()
        {
            this.getAProduct();
        }
    }
</script>