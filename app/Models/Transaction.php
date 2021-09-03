<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';


    function Account() {
        return $this->belongsTo('App\Account');
    }

    function Operation() {
        return $this->belongsTo('App\Operation');
    }
}
