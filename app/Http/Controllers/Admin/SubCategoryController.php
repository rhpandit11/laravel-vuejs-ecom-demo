<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SubCategories;

class SubCategoryController extends Controller
{
    #Add Sub Category
    public function addSubCategory(Request $request)
    {
        DB::beginTransaction();
        try
        {
            $getIdSCT = SubCategories::orderBy('id','DESC')->first();
            if(empty($getIdSCT)){$lastIdSCT = 0;}else{$lastIdSCT = intval(explode('-',$getIdSCT->subCategoryGenId)[1]);}
            $presentIdCT = $lastIdSCT + 1;

            $addSubCategory = new SubCategories;

            $addSubCategory->subCategoryGenId  = "SUBCAT-".str_pad($presentIdCT,5,"0", STR_PAD_LEFT);
            $addSubCategory->categoryId        = $request->categoryId;
            $addSubCategory->subCategoryName   = $request->subCategoryName;
            $addSubCategory->status            = $request->status;

            $addSubCategory->save();

            DB::commit();

            return array('success' => true, 'msg'=>['New Sub Category Added']);

        }catch(\Exception $e){
            DB::rollBack();
           
            if($e->errorInfo[1] == 1062){
                return array('success' => false, 'msg'=>['SubCategory already exists!']);
            }else{
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
         }

    }

     #Getting all Categories data
     public function getAllSubCategories()
     {
         return SubCategories::with('get_categories')->orderBy('id','ASC')->get();
     }
 
     public function editSubCategory($subCategoryGenId)
     {
       return SubCategories::with('get_categories')->where('subCategoryGenId',$subCategoryGenId)->first();
     }
 
     
     #updating All Sub Categories
     public function updateSubCategory($subCategoryGenId,Request $request)
     {
         DB::beginTransaction();
         try
         {
             $findCategory = SubCategories::where('subCategoryGenId',$subCategoryGenId)->first();
             $findCategory->subCategoryName    = $request->subCategoryName ;
             $findCategory->categoryId         = $request->categoryId ;
             $findCategory->status             = $request->status;
             $findCategory->update();
 
             DB::commit();
             return array('success' => true, 'msg'=>['Sub Category Updated']);
 
         }catch(\Exception $e){
             DB::rollBack();
            
             if($e->errorInfo[1] == 1062){
                 return array('success' => false, 'msg'=>['Sub Category already exists!']);
             }else{
                 return array('success' => false, 'msg'=>['Internal server error!']);
             }
          }
     }

     #delete Sub Category
    public function deleteSubCategory($subCategoryGenId)
    {
        DB::beginTransaction();
        try
        {
             SubCategories::where('subCategoryGenId',$subCategoryGenId)->delete();

            DB::commit();
            return array('success' => true, 'msg'=>['Sub Category Deleted']);

        }catch(\Exception $e){
            DB::rollBack();
           
            if($e->errorInfo[1]){
                return array('success' => false, 'msg'=>['Internal server error!']);
            }
         }
    }
 
}
