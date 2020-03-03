<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skubatch extends Model
{
    protected $table='skubatch';

    protected $fillable = ['id', 'batch', 'sku', 'gtin', 'expirydate'];

}
