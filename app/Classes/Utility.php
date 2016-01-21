<?php

namespace App\Classes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Products;

class Utility
{
	
	public static function get_store_name($user_id)
    {
        $data = DB::table('lookup_store')->where('user_id',$user_id)->first();
        $data = json_decode(json_encode($data), true);
        return $data['store_name'];
    }

    public static function get_slite_products($user_id)
    {
        //Redirect to view products
        $Prod = Products::where('user_id', '=', $user_id)->get();
        $Prod = json_decode(json_encode($Prod), true);
        //print_r($Prod);
        //die();
        return $Prod;
    }
}

?>