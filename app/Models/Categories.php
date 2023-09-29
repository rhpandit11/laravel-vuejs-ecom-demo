<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategories;
use App\Models\Products;

class Categories extends Model
{
    use HasFactory;

    public function sub_categories()
    {
        return $this->hasMany(SubCategories::class);
    }

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
