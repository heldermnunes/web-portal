<?php

namespace App\Modules\Api\Http\Controllers\v1_1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Http\Controllers\v1_0\v1m0_MainController;

class v1m1_MainController extends v1m0_MainController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        dd('here!! - 1.1');
    }
}
