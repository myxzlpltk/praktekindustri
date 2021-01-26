<?php

namespace App\Http\Controllers;

use App\Models\Coordinator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class CoordinatorController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(){
    	Gate::authorize('view-any', Coordinator::class);

        return view('coordinators.index', [
        	'coordinators' => Coordinator::with(['user', 'prodi'])->get()
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create(){
		Gate::authorize('create', Coordinator::class);

		return view('coordinators.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function store(Request $request){
		Gate::authorize('create', Coordinator::class);

		$request->validate([
			'name' => 'required|string',
			'email' => [
				'required',
				'string',
				'email',
				Rule::unique(User::class),
			],
			'id_type' => 'required|string',
			'id_number' => [
				'required',
				'string',
				'numeric',
				Rule::unique(User::class, 'username')
			],
			'password' => [
				'required',
				'string',
				new Password,
			]
		]);

		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->username = $request->id_number;
		$user->password = Hash::make($request->password);
		$user->role = 'coordinator';
		$user->save();
		$user->markEmailAsVerified();

		$coordinator = new Coordinator;
		$coordinator->user_id = $user->id;
		$coordinator->id_type = $request->id_type;
		$coordinator->id_number = $request->id_number;
		$coordinator->save();

		return redirect()->route('coordinators.show', $coordinator)->with([
			'success' => 'Koordinator berhasil ditambahkan.'
		]);
	}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coordinator  $coordinator
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Coordinator $coordinator){
		Gate::authorize('view', $coordinator);

        return view('coordinators.show', [
        	'coordinator' => $coordinator
		]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coordinator  $coordinator
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Coordinator $coordinator){
		Gate::authorize('update', $coordinator);

		return view('coordinators.edit', [
			'coordinator' => $coordinator
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coordinator  $coordinator
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function update(Request $request, Coordinator $coordinator){
		Gate::authorize('update', $coordinator);

		$request->validate([
			'name' => 'required|string',
			'email' => [
				'required',
				'string',
				'email',
				Rule::unique(User::class)->ignore($coordinator->user->id),
			],
			'id_type' => 'required|string',
			'id_number' => [
				'required',
				'string',
				'numeric',
				Rule::unique(User::class, 'username')->ignore($coordinator->user->id)
			]
		]);

		$user = $coordinator->user;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->username = $request->id_number;
		$user->save();

		$coordinator->id_type = $request->id_type;
		$coordinator->id_number = $request->id_number;
		$coordinator->save();

		return redirect()->route('coordinators.show', $coordinator)->with([
			'success' => 'Koordinator berhasil diperbarui.'
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coordinator  $coordinator
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function destroy(Coordinator $coordinator){
		Gate::authorize('delete', $coordinator);

		if($coordinator->prodi()->count() > 0){
			return redirect()->route('coordinators.show', $coordinator)->with([
				'error' => 'Koordinator tidak bisa dihapus karena masih terdapat prodi yang dibebankan.'
			]);
		}
		else{
			$coordinator->delete();

			return redirect()->route('coordinators.index')->with([
				'success' => 'Data koordinator berhasil dihapus.'
			]);
		}
    }

	/**
	 * Reset password coordinator.
	 *
	 * @param  \App\Models\Coordinator  $coordinator
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function resetPassword(Coordinator $coordinator){
		Gate::authorize('reset-password', $coordinator);

		$newPassword = Str::random(16);
		$coordinator->user->password = Hash::make($newPassword);
		$coordinator->user->save();

		return redirect()->route('coordinators.show', $coordinator)->with([
			'success' => 'Kata sandi berhasil direset. Kata sandi baru : '.$newPassword
		]);
	}
}
