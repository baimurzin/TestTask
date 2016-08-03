<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class BaseController extends Controller
{

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->data = [];
        $this->data['user'] = \Auth::user();
    }
}
