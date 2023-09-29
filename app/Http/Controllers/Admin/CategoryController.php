<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;
use App\Models\SubCategories;

class CategoryController extends Controller
{
    #Add Category
    public function addCategory(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $getIdCT = Categories::orderBy('id','DESC')->first();
            if(empty($getIdCT)){$lastIdCT = 0;}else{$lastIdCT = intval(explode('-',$getIdCT->categoryGenId)[1]);}
            $presentIdCT = $lastIdCT + 1;

            $addCategory = new Categories;

            $addCategory->categoryGenId  = "CAT-".str_pad($presentIdCT,5,"0", STR_PAD_LEFT);
            $addCategory->categoryName   = $request->categoryName;
            $addCategory->status         = $request->status;

            $addCategory->save();

            DB::commit();

            return array('success' => true, 'msg'=>['New Category Added']);

        }catch(\Exception $e){
            DB::rollBack();
           
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['Category already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
         }

    }

    #Getting all Categories data
    public function getAllCategories()
    {
        return Categories::orderBy('id','ASC')->get();
    }

    public function editCategory($categoryGenId)
    {
      return Categories::where('categoryGenId',$categoryGenId)->first();
    }

    #updating All Categories
    public function updateCategory($categoryGenId,Request $request)
    {
        DB::beginTransaction();
        try
        {
            $findCategory = Categories::where('categoryGenId',$categoryGenId)->first();
            $findCategory->categoryName   = $request->categoryName;
            $findCategory->status         = $request->status;
            $findCategory->update();

            DB::commit();
            return array('success' => true, 'msg'=>['Category Updated']);

        }catch(\Exception $e){
            DB::rollBack();
           
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['Category already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
         }
    }

    #delete Category
    public function deleteCategory($categoryGenId)
    {
        DB::beginTransaction();
        try
        {
            $findCategory = Categories::where('categoryGenId',$categoryGenId)->first();

            $countSubCat = SubCategories::where('categoryId',$findCategory->id)->count();
            if($countSubCat >= 1){
                return array('success' => false, 'msg'=>['Cannot delete the category as sub-category exists!']);
            }else{
                $findCategory->delete();
            }
            DB::commit();
            return array('success' => true, 'msg'=>['Category Deleted']);

        }catch(\Exception $e){
            DB::rollBack();
           
            if($e->errorInfo[1]){
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
         }
    }

   

    #Show all categories into sub-categories
    public function getAllCategory()
    {
        return Categories::orderBy('id','ASC')->get();
    }

    
}
