<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminSystemController;
use App\Http\Controllers\SystemController;

Route::group(['prefix' => 'admin'], function()  
{  
    #AUTH UI
    Route::get('/register'                             , [AdminSystemController::class ,'login']);
    Route::get('/login'                                , [AdminSystemController::class ,'login']);
    
    #CATEGORY UI
    Route::get('/'                                     , [AdminSystemController::class ,'index']);
    Route::get('/add-category'                         , [AdminSystemController::class ,'index']);
    Route::get('/edit-category/{categoryGenId}'        , [AdminSystemController::class ,'index']);
    Route::get('/manage-categories'                    , [AdminSystemController::class ,'index']);
    Route::get('/add-sub-category'                     , [AdminSystemController::class ,'index']);

    #SUB-CATEGORY UI
    Route::get('/add-sub-category'                     , [AdminSystemController::class ,'index']);
    Route::get('/manage-sub-categories'                , [AdminSystemController::class ,'index']);
    Route::get('/edit-sub-category/{categoryGenId}'    , [AdminSystemController::class ,'index']);

    #PRODUCTS UI
    Route::get('/add-product'                          , [AdminSystemController::class ,'index']);
    Route::get('/manage-products'                      , [AdminSystemController::class ,'index']);
    Route::get('/edit-product/{productId}'             , [AdminSystemController::class ,'index']);
});

   #USER SECTION
   Route::get('/'                                      , [SystemController::class ,'index']);
   Route::get('/view-product/{token}'                  , [SystemController::class ,'index']);


