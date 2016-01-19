<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Classes\Shopify;
use App\Classes\Vend;
use App\Classes\Token;
use App\Models\Products;

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
            //Assumming that StitchLite DB and Shopify/Vend were initially synced.
            //Get all products from Shopify and Vend
            //Remove the duplicate product from both or do on duplicate key update
            //$shopify->insert_db_once($rAllProducts,$user_id);

            //Do a query to get all the information back from lookup_product
            // $sQ = SELECT * FROM lookup_product where user_id = $user_id
            //Everytime when user log in or trigger an event (press a button), We do a GET request to Shopify/Vend
            
            //Once we have StitchLite data and new data from Shopify/Vend, we do a compare for each row.
            //If nothing changed then we continue the loop, otherwise we update each record that has changed.
            //If new item(s) are added, we will also insert those in the lookup_product table
            //$sQ = "INSERT INTO lookup_product (columns) values ($sValue) on duplicate key update title,quantity etc.. "
            $Prod = Products::where('user_id', '=', $user_id)->get();
            return view('products.index', ['lookup_products' => $Prod]);
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

}
