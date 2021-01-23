<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller{

	public function index(Request $request){
		//ignore this spaghetti pls
		$user = $request->user();
		$proposal = ($user->isStudent) ? Proposal::latest()->firstWhere('student_id', $user->student->id) : null;

		$statistik = (!$user->isStudent) ? (object) array(
			'total_mhs' => Student::all()->count(),
			'total_proposal' => Proposal::count(),
			'pr_acc' => Proposal::where('status_code', 5)->count(),
			'pr_tolak_kajur' => Proposal::where('status_code', 4)->count(),
			'pr_tolak_koor' => Proposal::where('status_code', 3)->count(),
			'pr_wait_kajur' => Proposal::where('status_code', 2)->count(),
			'pr_wait_koor' => Proposal::where('status_code', 1)->count()
		) : null;

		return view('dashboard', compact('proposal', 'statistik'));
	}
}
