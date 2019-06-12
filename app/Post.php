<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Post extends Model
{
    protected $fillable = [
    	'user_id',
    	'category_id',
    	'title',
        'body',  
    ];

    

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category(){
    	return $this->belongsTo('App\Category');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function likes(){
        return $this->hasMany('App\Like');
    }

    public function friends() {
        return $this->belongsToMany('App\Friend');
    }
    public function postMedia(){
        return $this->hasOne(postMedia::class);
    }

}
