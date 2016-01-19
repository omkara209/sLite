<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Classes\Shopify;
use App\Classes\Vend;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo 'here';
        
        $vend = new Vend();
        $vend->get_curl();
    }

    public function vend()
    {
        echo 'in vend';
        $vend = new Vend();
        $vend->get_vend_access($_GET['code']);
    }

    /*
    $api_key = "f807c12f4ea01c1c10981655ab41820e";
        $secret_key = "2334991c5041dbcea4b059564d74642c";
        $store_name = "sukhis-store";

        $shopify = new Shopify($api_key,$secret_key,$store_name);
        $rAllProducts = $shopify->get_all_products('GET');
        print_r($rAllProducts['products']);

    */
}
