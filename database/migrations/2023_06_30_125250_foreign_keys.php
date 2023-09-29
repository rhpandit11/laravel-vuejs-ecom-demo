<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->foreign('subCategoryId')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
