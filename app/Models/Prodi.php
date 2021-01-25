<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prodi extends Model{

    use HasFactory;

    public function students(){
    	return $this->hasMany(Student::class);
	}

	public function coordinator(){
    	return $this->belongsTo(Coordinator::class);
	}
}
