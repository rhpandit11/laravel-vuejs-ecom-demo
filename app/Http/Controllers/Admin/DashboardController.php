<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Models\Products;

class DashboardController extends Controller
{
     #Count of all data for dashboard
     public function getCount()
     {
         $data = array();
         $data['totalCategories']    = Categories::count();
         $data['totalSubCategories'] = SubCategories::count();
         $data['totalProducts']      = Products::count();
         return $data;
     } 
}
