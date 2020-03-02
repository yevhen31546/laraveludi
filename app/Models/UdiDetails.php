<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UdiDetails extends Model{

    protected $table='udi_details';

    protected $fillable = ['id','udi','di','expirationDate','serialNumber','deviceName','manufacturerName','address'];

    
}