<?php

namespace App\Http\Controllers;

use App\Products;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    /**
     * Show a list of all available flights.
     *
     * @return Response
     */
    public function index()
    {
        $products = Products::all();
        echo 'in product_controller';
        return view('products.index', ['products' => $products]);
    }
}