<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model{

    use HasFactory;

	public function getNameAttribute(){
		return $this->user->name;
	}

	public function user(){
		return $this->morphOne(User::class, 'userable', 'role', 'id', 'user_id');
	}
}
