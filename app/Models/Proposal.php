<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
