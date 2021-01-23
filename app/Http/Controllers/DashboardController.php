<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller{

	public function index(Request $request){
		//ignore this spaghetti pls
		$proposal = (Auth::user()->role == "student") ? Proposal::firstWhere('student_id', Auth::user()->student->id) : null;
		return view('dashboard', compact('proposal'));
	}
}
