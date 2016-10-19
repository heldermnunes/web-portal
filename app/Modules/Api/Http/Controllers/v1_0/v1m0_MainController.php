<?php

namespace App\Modules\Api\Http\Controllers\v1_0;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Modules\Api\Http\Controllers\ApiController;
use App\Modules\Api\UrlHelper;

class v1m0_MainController extends ApiController
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return ('here!! - 1.0');
    }

    public function login()
    {

    }
}
