<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Proposal {
    public static function proposalGetStatusClass($status_code) {
        switch ($status_code) {
			case (1):
			case (2):
				return "badge-warning";
				break;
			case (3):
			case (4):
				return "badge-danger";
				break;
			case (5):
				return "badge-success";
				break;
			default:
				return "badge-secondary";
				break;
		}
    }
}

?>
