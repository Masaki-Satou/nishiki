<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function __construct(){

        $this->middleware('auth:owners');
    
    }

    
}
