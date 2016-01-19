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
    	$url = "https://secure.vendhq.com/connect?response_type=code&client_id=nyZV30AraVV7eMBrtTp38fA42lJ0oYHN&redirect_uri=http://localhost:8000/VendRequest";

    	 // create curl resource 
        $ch = curl_init(); 
        // set url 
        $options = array(
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_HTTPHEADER => array('Content-type: application/text')
        );

        curl_setopt_array($ch, $options);

        // $output contains the output string 
        $output = curl_exec($ch); 
        var_dump($output);
    }

    public function get_vend_access($code)
    {
    	if ($code) 
    	{

	    	$api_key = "nyZV30AraVV7eMBrtTp38fA42lJ0oYHN";
	    	$secret_key = "muqlnclZ4kd4hg5F9JDnz9hYVSoCCBc1";
	    	// If the variable 'code' is present in the URI then save the relevant values
		    $data = array(
		            'code' => $code,
		            'client_id' => $api_key,
		            'client_secret' => $secret_key,
		            'grant_type' => 'authorization_code',
		            'redirect_uri' => "http://localhost/8000/VendRequestStore"
		    	);

		     // Prepare a request to POST to vend
		    $url = "https://joshstore.vendhq.com/api/1.0/token";

		    $ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded'));
			$response = curl_exec($ch);
			var_dump($response);

    	}
    }

    public function get_all_products()
    {

    }

}