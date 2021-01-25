<?php

namespace App\Http\Controllers;

use App\DataTables\Scopes\StudentByProdiScope;
use App\DataTables\StudentDataTable;
use App\Models\Coordinator;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ProdiController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(){
        Gate::authorize('view-any', Prodi::class);

        return view('prodi.index', [
        	'prodis' => Prodi::with('coordinator.user')->get()
		]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function show(StudentDataTable $dataTable, Prodi $prodi){
        Gate::authorize('view', $prodi);

        return $dataTable
			->addScope(new StudentByProdiScope($prodi))
			->render('prodi.show', [
				'prodi' => $prodi
			]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Prodi $prodi){
        Gate::authorize('update', $prodi);

        return view('prodi.edit', [
        	'prodi' => $prodi,
			'coordinators' => Coordinator::with('user')->get()
		]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\RedirectResponse
	 */
    public function update(Request $request, Prodi $prodi){
		Gate::authorize('update', $prodi);

		$request->validate([
			'coordinator_id' => [
				'required',
				Rule::exists(Coordinator::class, 'id')
			]
		]);

		$prodi->coordinator_id = $request->coordinator_id;
		$prodi->save();

		return redirect()->route('prodi.show', $prodi)->with([
			'success' => 'Koordinator berhasil diperbarui.'
		]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prodi  $prodi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prodi $prodi)
    {
        //
    }
}
