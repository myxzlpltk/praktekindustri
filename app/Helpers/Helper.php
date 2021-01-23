<?php
namespace App\Helpers;

use App\Models\Proposal;

class Helper {

	public static function proposalStatusClass($code){
		$classes = [
			Proposal::STATUS_Tunggu_TTDKoor => 'badge-warning',
			Proposal::STATUS_Tunggu_TTDKajur => 'badge-warning',
			Proposal::STATUS_Ditolak_Koor => 'badge-danger',
			Proposal::STATUS_Ditolak_Kajur => 'badge-danger',
			Proposal::STATUS_Disahkan => 'badge-success',
		];

		return key_exists($code, $classes)
			? __($classes[$code])
			: __('');
	}
}
