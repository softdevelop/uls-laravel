<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{   

    /**
     * getSelectPlatform
     * @return [type] [description]
     */
    public function getIndex()
    {
    	// die('111');
       return view('products.index');
    }

}
