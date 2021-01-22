<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Proposal extends Model
{
		use HasFactory;

		/**
     * fillable
     *
     * @var array
     */
  protected $fillable = [
			'user_id', 'lokasi_prakerin', 'tgl_sah', 'file_proposal', 'status', 'lembar_sah'
	];

	/**
	 * Many to One Proposal - User
	 */
	public function user(){
		return $this->belongsTo(User::class, 'user_id');
	}

	/**
	 * tampilkan tanggal pengesahan
	 */
	public function tgl_sah_view(){
		return Carbon::parse($this->tgl_sah)->isoFormat('D MMMM Y');
	}
}

