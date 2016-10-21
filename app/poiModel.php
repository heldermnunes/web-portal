<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class poiModel extends Model
{
    public function storePoi (array $data = [])
    {
        $poi =  DB::table('poi')
            ->where([
                    'description'=> $data['description'],
                    'titlte' => $data['title'],
                    'date' => $data['date']
                ]
            )->first();

        if ($poi) {
            return false;
        }

        $result = DB::table('poi')->insert($data);
        if ( $result )  {
            $rowId = DB::connection() -> getPdo() -> lastInsertId();
            return $rowId;
        }
        return false;
    }
}
