<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\SubCategories;

class Products extends Model
{
    use HasFactory;

    public function get_categories()
    {
      return $this->belongsTo(Categories::class,'categoryId');    
    }

    public function get_sub_categories()
    {
      return $this->belongsTo(SubCategories::class,'subCategoryId');    
    }
}
