<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductManagerController extends Controller
{
    public function index()
    {
        return view('product-managers.index');
    }
}
