<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProfileController extends Controller{

	public function index(Request $request){
		return view('profiles.index', [
			'user' => $request->user()
		]);
	}

	public function coordinatorUpdate(Request $request){
		Gate::authorize('isCoordinator');

		$request->validate([
			'id_type' => 'required|string',
			'id_number' => 'required|string',
		]);

		$coordinator = $request->user()->coordinator;
		$coordinator->id_type = $request->id_type;
		$coordinator->id_number = $request->id_number;
		$coordinator->save();

		return redirect()->route('profile')->with([
			'success' => 'Data berhasil diperbarui'
		]);
	}
}
