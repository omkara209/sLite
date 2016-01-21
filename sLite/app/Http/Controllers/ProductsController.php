<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Http\Controllers\Controller;
use App\Classes\Shopify;
use App\Classes\Vend;
use App\Classes\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function syncData()
    {
        $user_id = Auth::user()->id;
        $store_name = $this->get_store_name($user_id);

        $shopify = new Shopify(Token::$shopify_api_key, Token::$shopify_secret_key, $store_name);
        $rAllProducts = $shopify->get_all_products('GET');

        $rVariants = array();
        $sValues = "";
        $rInsert = array();

        foreach ($rAllProducts as $rP)
        {
            foreach ($rP as $rPP)
            {
                $rVariants[] = $rPP['variants'];
            }
        }

        foreach ($rVariants as $rV)
        {
            foreach ($rV as $rVV)
            {
                $rInsert[] = array('sku' => $rVV['sku'],'product_name' => $rVV['title'],
                            'quantity' =>$rVV['inventory_quantity'],'price' =>$rVV['price']);
            }
        }

        //print_r($rInsert);

        $rProd = Products::where('user_id', '=', $user_id)->get();
        $rProd = json_decode(json_encode($rProd), true);

        //Make SKU the key
        $rData=array();
        foreach ($rProd as $rP)
        {
            $key = $rP['sku'];
            $rData[$key]['product_name'] = $rP['product_name'];
            $rData[$key]['quantity'] = $rP['quantity'];
            $rData[$key]['price'] = $rP['price'];
        }

        $rDiff = array();
        $rNew = array();
        //print_r($rInsert);
        //die();
        //Compare both arrays now to see any difference and get the difference in new array
        foreach ($rInsert as $rI)
        {
            if (isset($rData[$rI['sku']]))
            {
                //Check for product_name, quantity,price
                if ($rI['product_name'] != $rData[$rI['sku']]['product_name'])
                {
                    $rDiff[$rI['sku']]['product_name'] = $rI['product_name'];
                }

                if ($rI['quantity'] != $rData[$rI['sku']]['quantity'])
                {   
                    $rDiff[$rI['sku']]['quantity'] = $rI['quantity'];
                }

                if ($rI['price'] != $rData[$rI['sku']]['price'])
                {   
                    $rDiff[$rI['sku']]['price'] = $rI['price'];
                }

            }
            else //New Entry
            {
                $rNew[$rI['sku']]['product_name'] = $rI['product_name'];
                $rNew[$rI['sku']]['quantity'] = $rI['quantity'];
                $rNew[$rI['sku']]['price'] = $rI['price'];
            }
        }
        //Update each changed entry
        foreach ($rDiff as $rK => $rV)
        {
            $sQ = "update lookup_products set ";
            foreach ($rV as $rKK => $rVV)
                $sQ .= "{$rKK} = '$rVV',";

            $sQ = substr($sQ, 0,-1);
            $sQ .= " where sku = ?";

            DB::update($sQ, [$rK]);
        }

        //Add new Entry
        foreach ($rNew as $rK=> $rV)
        {
            $sQ = "insert into lookup_products (sku,product_name,quantity,price,user_id) values (?, ?, ?, ?, ?)";
            DB::insert($sQ, [$rK, $rV['product_name'], $rV['quantity'],$rV['price'], $user_id]);
        }


        //Redirect to view products
        $Prod = Products::where('user_id', '=', $user_id)->get();
        return view('products.index', ['lookup_products' => $Prod]);
    }

    public function get_store_name($user_id)
    {
        $data = DB::table('lookup_store')->where('user_id',$user_id)->first();
        $data = json_decode(json_encode($data), true);
        return $data['store_name'];
    }
}