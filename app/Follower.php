<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
	protected $guarded = ['id'];
	
	public function friend()
	{
		return $this->hasOne('App\User', 'friend_id', 'id');
	}

	public function user()
	{
		return $this->belongTo('App\User');
	}
}
