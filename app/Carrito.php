<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    //
    protected $fillable = [
        'id_orden','id_producto','cantidad','nombre', 'descripcion','precio'
    ];

}
