<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\HomepageController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(['prefix' => 'admin'], function()  
{  
    #AUTH-API
    Route::post('/register'                        , [AuthenticationController::class ,'register']);
    Route::post('/login'                           , [AuthenticationController::class ,'login']);

    #CATEGORY-API
    Route::post('/add-category'                    , [CategoryController::class ,'addCategory']);
    Route::get('/manage-categories'                , [CategoryController::class ,'getAllCategories']);
    Route::get('/edit-category/{categoryGenId}'    , [CategoryController::class ,'editCategory']);
    Route::post('/update-category/{categoryGenId}' , [CategoryController::class ,'updateCategory']);
    Route::post('/delete-category/{categoryGenId}' , [CategoryController::class ,'deleteCategory']);
    Route::get('/get-all-categories'               , [CategoryController::class ,'getAllCategory']);
    
    #SUBCATEGORY-API
    Route::post('/add-sub-category'                        , [SubCategoryController::class ,'addSubCategory']);
    Route::get('/manage-sub-categories'                    , [SubCategoryController::class ,'getAllSubCategories']);
    Route::get('/edit-sub-category/{subCategoryId}'        , [SubCategoryController::class ,'editSubCategory']);
    Route::post('/update-sub-category/{subCategoryGenId}'  , [SubCategoryController::class ,'updateSubCategory']);
    Route::post('/delete-sub-category/{subCategoryId}'     , [SubCategoryController::class ,'deleteSubCategory']);

    #PRODUCT API
    Route::get('/get-all-sub-categories/{categoryId}'       , [ProductController::class ,'getAllSubCategories']);
    Route::post('/add-product'                              , [ProductController::class ,'addProduct']);
    Route::get('/manage-products'                           , [ProductController::class ,'getProducts']);
    Route::get('/edit-product/{productId}'                  , [ProductController::class ,'editProduct']);
    Route::post('/update-product/{productId}'               , [ProductController::class ,'updateProduct']);
    Route::post('/delete-product/{productId}'               , [ProductController::class ,'deleteProduct']);

    #DASHBOARD COUNT
    Route::get('/count-dashboard'                           , [DashboardController::class ,'getCount']);

    #LOGOUT-API
    Route::post('/logout'                                   , [AuthenticationController::class ,'logout']);
}); 

    #HOMEPAGE
    Route::get('/products'                                     , [HomepageController::class ,'getAllProduct']);
    Route::get('/get-all-categories'                           , [HomepageController::class ,'getAllCategories']);
    Route::get('/view-product/{token}'                         , [HomepageController::class ,'getAProduct']);
    
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
