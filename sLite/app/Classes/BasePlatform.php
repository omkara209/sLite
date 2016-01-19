<?php

namespace App\Classes;

interface BasePlatform
{   
    public function get_all_products();

    //More methods can be included
    //get_product_by_id
    //get_variant_by_sku
    //get_product_by_sku etc...

}

?>