<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model{

    use HasFactory;

    public function getNameAttribute(){
    	return $this->user->name;
	}

    public function user(){
    	return $this->belongsTo(User::class, 'user_id');
	}

	public function proposals(){
		return $this->hasMany(Proposal::class);
	}

	public function prodi(){
		return $this->belongsTo(Prodi::class);
	}
}
