<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Models\Products;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // getting Category wise subcategory data in product from
    public function getAllSubCategories($categoryId)
    {
        return SubCategories::where('categoryId', $categoryId)->where('status', 1)->get();
    }

    #Add Product
    public function addProduct(Request $request)
    {   
        $this->createFolder();

        DB::beginTransaction();
        try
        {
            $token = Str::random(64);

            $getIdPR = Products::orderBy('id','DESC')->first();
            if(empty($getIdPR)){$lastIdPR = 0;}else{$lastIdPR = intval(explode('-',$getIdPR->productGenId)[1]);}
            $presentIdPR = $lastIdPR + 1;

            $addProduct = new Products;

            $addProduct->productGenId          = "PRO-".str_pad($presentIdPR,5,"0", STR_PAD_LEFT);
            $addProduct->categoryId            = $request->categoryId;
            $addProduct->subCategoryId         = $request->subCategoryId;
            $addProduct->productBrandName      = $request->productBrandName;
            $addProduct->productName           = $request->productName;
            $addProduct->productPrice          = $request->productPrice;
            $addProduct->status                = $request->status;
            $addProduct->stockStatus           = $request->stockStatus;
            $addProduct->token                 = $token;

            if(isset($request->productImageFile))
            {
                $fileName  = $this->uploadFile('app/public/uploads/products/',$request->productImageFile, $request->productImageName);
            }else{
                $fileName = '';
            }
            $addProduct->productImage = $fileName;
            $addProduct->save();

            DB::commit();

            return array('success' => true, 'msg'=>['New Product Added']);

        }catch(\Exception $e){
            DB::rollBack();
        
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['Product already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
        }
    }

    #getting Products table data
    public function getProducts()
    {
        $getAllProducts = Products::with('get_categories')->with('get_sub_categories')->orderBy('id','ASC')->get();

        foreach($getAllProducts as $key => $products)
        {
           
            $productImg          = Storage::disk('ecom')->get('app/public/uploads/products/'.$products['productImage']);
            $getExt              = Storage::disk('ecom')->mimeType('app/public/uploads/products/'.$products['productImage']);
            $url                 = 'data:'.$getExt.';base64,'.base64_encode($productImg);
            $getAllProducts[$key]['fileURL'] = $url;
        }
        return $getAllProducts;
    }

    #Edit Product
    public function editProduct($productId)
    {
        $getAProduct = Products::where('productGenId',$productId)->with('get_categories')->with('get_sub_categories')->first();
        if(isset($getAProduct))
        {
            $productImg          = Storage::disk('ecom')->get('app/public/uploads/products/'.$getAProduct->productImage);
            $getExt              = Storage::disk('ecom')->mimeType('app/public/uploads/products/'.$getAProduct->productImage);
            $url                 = 'data:'.$getExt.';base64,'.base64_encode($productImg);
            $getAProduct['fileURL'] = $url;
            return $getAProduct;
        }
    }

    #Update product
    public function updateProduct($productId , Request $request)
    {
        DB::beginTransaction();
        try
        {
            $findProduct = Products::where('productGenId',$productId)->with('get_categories')->with('get_sub_categories')->first();

            $findProduct->categoryId            = $request->categoryId;
            $findProduct->subCategoryId         = $request->subCategoryId;
            $findProduct->productBrandName      = $request->productBrandName;
            $findProduct->productName           = $request->productName;
            $findProduct->productPrice          = $request->productPrice;
            $findProduct->status                = $request->status;
            $findProduct->stockStatus           = $request->stockStatus;

            if(isset($request->productImageFile))
            {
                if(!empty($findProduct->productImage) && !empty(Storage::disk('ecom')->exists('app/public/uploads/products/'.$findProduct->productImage)))
                {
                    Storage::disk('ecom')->delete('app/public/uploads/products/'.$findProduct->productImage);
                    $fileName = $this->uploadFile('app/public/uploads/products/', $request->productImageFile, $request->productImageName);
                    $findProduct->productImage = $fileName;
                }else{
                    $fileName = $this->uploadFile('app/public/uploads/products/', $request->productImageFile, $request->productImageName);
                    $findProduct->productImage = $fileName;
                }
            }

            $findProduct->update();

            DB::commit();
            return array('success' => true, 'msg'=>['Product Updated']);

        }catch(\Exception $e){
            DB::rollBack();
        
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['Product already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
        }
    }

    #delete Product
    public function deleteProduct($productId)
    {
        DB::beginTransaction();
        try
        {
            $findProduct = Products::where('productGenId',$productId)->with('get_categories')->with('get_sub_categories')->first();

            if(!empty($findProduct->productImage) && !empty(Storage::disk('ecom')->exists('app/public/uploads/products/'.$findProduct->productImage))){
                Storage::disk('ecom')->delete('app/public/uploads/products/'.$findProduct->productImage);
            }
            $findProduct->delete();
            DB::commit();   
            return array('success' => true, 'msg'=>['Product Deleted']);

        }catch(\Exception $e){
            DB::rollBack();
        
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['Product already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
        }
    }

    #Upload Product Image
    public function uploadFile(string $path,$base64file,string $filename='')
    {   
        $File =  explode(',', $base64file);
        $file = base64_decode($File[1]);
        $extension = explode(';',explode('/',$File[0])[1])[0];

        if ($filename !== '') {
            $fileName = rand().'~'.$filename;
        } else {
            $fileName = rand().'.'.$extension;
        }

        $path = $path.$fileName;
        Storage::disk('ecom')->put($path,$file);
        return $fileName;
    }

    #creating folder outside of project directory for image uploading
    private function createFolder()
    {
        if(!Storage::disk('ecom')->exists('app/public/uploads/products/')){
            Storage::disk('ecom')->makeDirectory('app/public/uploads/products/');
        }
    }
}
