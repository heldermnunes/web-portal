<?php

namespace App\Modules\Api\Models\v1_0;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class v1m0_poiCategoryModel extends Model
{
    public function getPoiCategories()
    {
        return DB::table('poiCategories')->get();
    }

    public function getCategoryById($id)
    {
        return DB::table('poiCategories')->where('id_poiCategories', $id)->first();
    }

    public function getPoiCategoriesByCategory($category)
    {
        $categoryId = (new v1m0_categoryModel())->getCategoryIdByName($category);


        $rows = DB::table('poiCategories')->where('fk_categories', $categoryId)->get();

        return json_decode(json_encode($rows), true);
    }

}
