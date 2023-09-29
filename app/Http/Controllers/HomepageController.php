<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    public function getAllProduct()
    {
        $getAllProducts = Products::orderBy('id','ASC')->get();

        foreach($getAllProducts as $key => $products)
        {
           
            $productImg          = Storage::disk('ecom')->get('app/public/uploads/products/'.$products['productImage']);
            $getExt              = Storage::disk('ecom')->mimeType('app/public/uploads/products/'.$products['productImage']);
            $url                 = 'data:'.$getExt.';base64,'.base64_encode($productImg);
            $getAllProducts[$key]['fileURL'] = $url;
        }
        return $getAllProducts;
    }

    public function getAllCategories()
    {
        return Categories::all();
    }
    
    public function getAProduct($token)
    {
        $findProduct = Products::where('token',$token)->first();

        $productImg          = Storage::disk('ecom')->get('app/public/uploads/products/'.$findProduct->productImage);
        $getExt              = Storage::disk('ecom')->mimeType('app/public/uploads/products/'.$findProduct->productImage);
        $url                 = 'data:'.$getExt.';base64,'.base64_encode($productImg);
        $findProduct['fileURL'] = $url;

        return $findProduct;

    }
}
