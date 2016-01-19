<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Classes\Shopify;
use App\Classes\Vend;
use App\Classes\Token;
use App\Products;

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
        //get the store name from database when user login.
        if (Auth::check())
        {
            $user_id = Auth::user()->id;
            $store_name = $this->get_store_name($user_id);

            $shopify = new Shopify(Token::$shopify_api_key, Token::$shopify_secret_key, $store_name);
            $rAllProducts = $shopify->get_all_products('GET');

            //Display all products and insert into DB
            $Prod = Products::all();
            return view('welcome', ['lookup_products' => $Prod]);
            //$shopify->insert_db($rAllProducts,$user_id);
        }
        //$vend = new Vend();
        //$vend->get_curl();
    }

    public function vend()
    {
        echo 'in vend';
        $vend = new Vend();
        $vend->get_vend_access($_GET['code']);
    }


    public function get_store_name($user_id)
    {
        $data = DB::table('lookup_store')->where('user_id',$user_id)->first();
        $data = json_decode(json_encode($data), true);
        return $data['store_name'];
    }
}
