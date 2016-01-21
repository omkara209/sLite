<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
   
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'lookup_products';

    public function update_product()
    {
    	print_r('here');
    }
}