<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Products;

class SubCategories extends Model
{
    use HasFactory;

    public function get_categories()
    {
      return $this->belongsTo(Categories::class,'categoryId');    
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
