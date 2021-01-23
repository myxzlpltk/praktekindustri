<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Proposal extends Model{

	use HasFactory;

	public const STATUS_Tunggu_TTDKoor = 1;
	public const STATUS_Tunggu_TTDKajur = 2;
	public const STATUS_Ditolak_Koor = 3;
	public const STATUS_Ditolak_Kajur = 4;
	public const STATUS_Disahkan = 5;

	public const status = [
		self::STATUS_Tunggu_TTDKoor => 'Tunggu TTD koordinator praktek industri.',
		self::STATUS_Tunggu_TTDKajur => 'Tunggu TTD ketua jurusan.',
		self::STATUS_Ditolak_Koor => 'Ditolak koordinator praktek industri.',
		self::STATUS_Ditolak_Kajur => 'Ditolak ketua jurusan.',
		self::STATUS_Disahkan => 'Disahkan.',
	];

	protected $fillable = [
		'user_id', 'lokasi_prakerin', 'tgl_sah', 'file_proposal', 'status', 'lembar_sah'
	];

	public function getStatusAttribute(){
		return key_exists($this->status_code, self::status)
			? __(self::status[$this->status_code])
			: __('Tidak Diketahui.');
	}

	public function student(){
		return $this->belongsTo(Student::class);
	}

	public function getTglSahViewAttribute(){
		return Carbon::parse($this->tgl_sah)->isoFormat('D MMMM Y');
	}
}

