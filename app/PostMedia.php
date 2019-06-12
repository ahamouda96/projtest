<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMedia extends Model
{

    public function post(){
        return $this->belongsTo('App\Post');
    }
}
