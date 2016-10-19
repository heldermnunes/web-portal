<?php

namespace App\Modules\Api\Models\v1_0;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class v1m0_categoryModel extends Model
{
    public function getCategoryById($id)
    {
        return DB::table('categories')->where('id_categories', $id)->first();
    }

    public function getCategoryIdByName($categoryName)
    {
        $category =  DB::table('categories')->where('description', $categoryName)->first();
        return (int) $category->id_categories;
    }

    public function getCategories()
    {
        return DB::table('categories')->get();
    }

    public function getItemUrl($id)
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/api/v1.0/category/getcategorybyid/' . $id;

    }
}
