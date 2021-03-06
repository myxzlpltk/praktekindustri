<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail{

	use HasFactory, Notifiable;

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/* Role */
	public function getIsAdminAttribute(){
		return $this->role == 'admin';
	}
	public function getIsStudentAttribute(){
		return $this->role == 'student';
	}
	public function getIsCoordinatorAttribute(){
		return $this->role == 'coordinator';
	}

	public function userable(){
		return $this->morphTo(__FUNCTION__, 'role', 'id', 'user_id');
	}

	public function leader(){
		return $this->hasOne(Leader::class);
	}

	public function Coordinator(){
		return $this->hasOne(Coordinator::class);
	}

	public function student(){
		return $this->hasOne(Student::class);
	}
}
