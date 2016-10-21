<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class categoryModel extends Model
{
    public function storeCategory ($data)
    {
        $category =  DB::table('categories')
            ->where('description', $data)->first();
        if ($category) {
            return (int) $category->id_categories;
        }

        $result = DB::table('categories')->insert($data);
        if ( $result )  {
            return (int) DB::connection() -> getPdo() -> lastInsertId();
        }
        return false;
    }
}
