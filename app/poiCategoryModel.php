<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class poiCategoryModel extends Model
{
    public function storePoiCategory($poiId, $categoryId)
    {
        $poiCategory =  DB::table('poiCategories')
            ->where([
                    'fk_poi' => $poiId,
                    'fk_categories' => $categoryId
            ]

            )->first();
        if ($poiCategory) {
            return (int) $poiCategory->id_categories;
        }

        $result = DB::table('poiCategories')->insert(
            [
                'fk_poi' => $poiId,
                'fk_categories' => $categoryId
            ]
        );
        if ( $result )  {
            return (int) DB::connection() -> getPdo() -> lastInsertId();
        }
        return false;
    }
}
