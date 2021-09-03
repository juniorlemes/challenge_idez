<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAccount extends Model
{

    protected $table = 'tipo_account';
    
    protected $fillable = [
        'id',
        'tipo',
        'created_at	'
    ];
}
