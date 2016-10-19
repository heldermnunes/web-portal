<?php

namespace App\Modules\Api\Models\v1_0;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class v1m0_poiModel extends Model
{
    public function getPoiById($id)
    {
        return DB::table('poi')->where('id_poi', $id)->first();
    }

    public function getPois()
    {
        return DB::table('poi')->get();
    }

    public function getItemUrl($id)
    {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/api/v1.0/poi/getpoisbyid/' . $id;

    }

}
