<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{

    public function time()
    {
        $time = "{\"now\":" . time() . "}";
        return $time;
    }

}