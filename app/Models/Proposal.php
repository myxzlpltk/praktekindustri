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
		self::STATUS_Tunggu_TTDKoor => 'Menunggu TTD Koordinator',
		self::STATUS_Tunggu_TTDKajur => 'Menunggu TTD Ketua Jurusan',
		self::STATUS_Ditolak_Koor => 'Ditolak Oleh Koordinator',
		self::STATUS_Ditolak_Kajur => 'Ditolak Oleh Ketua Jurusan',
		self::STATUS_Disahkan => 'Telah Disahkan',
	];

	protected $fillable = [
		'user_id', 'lokasi_prakerin', 'tgl_sah', 'file_proposal', 'status', 'lembar_sah'
	];

	public $dates = ['tgl_sah'];

	public function scopeCoordinator($query, Coordinator $coordinator){
		$query->whereHas('student.prodi', function ($query) use ($coordinator){
			$query->where('id', $coordinator->id);
		});
	}

	public function getStatusAttribute(){
		return key_exists($this->status_code, self::status)
			? __(self::status[$this->status_code])
			: __('Belum Mengajukan');
	}

	public function student(){
		return $this->belongsTo(Student::class);
	}
}

