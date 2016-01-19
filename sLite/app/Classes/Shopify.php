<?php

    // Source : https://github.com/Mochaka/laravel-shopify/blob/master/src/Mochaka/Shopify/Shopify.php
namespace App\Classes;

class Shopify
{
    //https://f807c12f4ea01c1c10981655ab41820e:2334991c5041dbcea4b059564d74642c@sukhis-store.myshopify.com/admin/products.json

    private $api_key;
    private $secret_key;
    private $store_name;

    public function __construct($api_key, $secret_key,$store_name)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
        $this->store_name = $store_name;
    }


    private function get_curl($rest_type = 'GET', $sEndingURL)
    {       
        $url = "https://" . $this->api_key . ":" . $this->secret_key . "@" . $this->store_name . ".myshopify.com/".$sEndingURL;
        // create curl resource 
        $ch = curl_init($url); 

        // set url 
        $options = array(
            CURLOPT_CUSTOMREQUEST   => $rest_type,
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYPEER  => false,
            CURLOPT_HTTPHEADER      => array('Content-type: application/json'),
        );

        curl_setopt_array($ch, $options); 

        // $output contains the output string 
        $output = curl_exec($ch); 
        // close curl resource to free up system resources 
        curl_close($ch);

        return json_decode($output,true);
    }

    public function get_all_products()
    {   
        $sEndingURL = 'admin/products.json';
        $data = $this->get_curl('GET', $sEndingURL);
        return $data;
    }

}

?>