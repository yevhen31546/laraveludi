<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UdiDocument extends Model{

    protected $table='udi_document';

    protected $fillable = ['id','di','image','document'];


}