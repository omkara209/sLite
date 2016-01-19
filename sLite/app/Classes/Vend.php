<?php

namespace App\Classes;

class Vend implements BasePlatform
{
    //https://f807c12f4ea01c1c10981655ab41820e:2334991c5041dbcea4b059564d74642c@sukhis-store.myshopify.com/admin/products.json

    private $api_key;
    private $secret_key;
    private $store_name;


    public function get_curl()
    {
    	$url = "https://secure.vendhq.com/connect?response_type=code&client_id=".Token::$vend_api_key."&redirect_uri=http://localhost:8000/VendRequest";

    	 // create curl resource 
        $ch = curl_init($url); 
        // set url 
        $options = array(
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_FOLLOWLOCATION => true,  
        );

        curl_setopt_array($ch, $options);

        // $output contains the output string 
        $output = curl_exec($ch); 
        //print_r(curl_getinfo($ch));
		//echo curl_errno($ch);
		//echo curl_error($ch);
        var_dump($output);

        curl_close($ch);
    }

    public function get_vend_access($code)
    {
    	if ($code) 
    	{
	    	// If the variable 'code' is present in the URI then save the relevant values
		    $data = array(
		            'code' => $code,
		            'client_id' => Token::$vend_api_key,
		            'client_secret' => Token::$vend_secret_key,
		            'grant_type' => 'authorization_code',
		            'redirect_uri' => "http://localhost/8000/VendRequest"
		    	);

		     // Prepare a request to POST to vend
		    $url = "https://sukhisstore.vendhq.com/api/1.0/token";

		    $ch = curl_init($url);
			//curl_setopt($ch,CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($ch);
			print_r(curl_getinfo($ch));
			echo curl_errno($ch);
			echo curl_error($ch);
			var_dump($response);

    	}
    }

    public function get_all_products()
    {

    }

}