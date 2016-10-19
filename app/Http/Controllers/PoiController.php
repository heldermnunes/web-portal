<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PoiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return 'index';
    }

    public function editPoi()
    {
        return 'editPoi';
    }

    public function addPoi()
    {
        return 'addPoi';
    }
}
