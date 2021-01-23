<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProposalController extends Controller{

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function index(){
		Gate::authorize('view-any', Proposal::class);

		return view('proposals.waiting_list', [
			'proposals' => Proposal::latest()->paginate(10)
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function create(Request $request){
		Gate::authorize('create', Proposal::class);

		return view('proposals.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request){
		Gate::authorize('create', Proposal::class);

		/* Unset session preview pathfile */
		if($request->session()->has('preview_pathfile')){
			Storage::disk('local')->delete(session('preview_pathfile'));
			$request->session()->forget('preview_pathfile');
		}

		/* validasi data */
		$request->validate([
			'f_fileproposal' => 'required|mimes:pdf',
			'f_lokasi' => 'required',
			'f_tgl_sah' => 'required',
		]);

		/* Request file */
		$file_proposal = $request->file('f_fileproposal');
		$fileName = "Proposal_".Auth::user()->name."_".Auth::user()->student->nim.'.pdf';
		$file_proposal->storeAs("proposal/", $fileName);

		$proposal = new Proposal;
		$proposal->file_proposal = $fileName;
		$proposal->lokasi_prakerin = $request->f_lokasi;
		$proposal->tgl_sah = $request->f_tgl_sah;
		$proposal->status_code = Proposal::STATUS_Tunggu_TTDKoor;
		$proposal->student_id = Auth::user()->student->id;

		if($proposal->save()){
			return redirect()->route('dashboard')->with(['success' => 'Proposal Berhasil Diajukan!']);
		} else{
			return redirect()->route('proposals.create')->with(['failed' => 'Terjadi Kesalahan!']);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Proposal  $proposal
	 * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
	 */
	public function show(Proposal $proposal){
		//Gate::authorize('show', $proposal);

		return view('proposals.pengesahan', compact('proposal'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Models\Proposal  $proposal
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Proposal $proposal){
		Gate::authorize('update', $proposal);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Proposal  $proposal
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Proposal $proposal){
		Gate::authorize('update', $proposal);

		$tahap = ($proposal->status_code == Proposal::STATUS_Tunggu_TTDKajur) ? 2 : 1;
		if($request->f_p_st == "tolak"){
			$proposal->status_code = ($tahap == 2) ? Proposal::STATUS_Ditolak_Kajur : Proposal::STATUS_Ditolak_Koor;

			if($tahap == 1){
				$proposal->alasanKoor = $request->f_alasan;
			} else{$proposal->alasanKajur = $request->f_alasan;}

		} else if($request->f_p_st == "valid"){
			list($ext, $data)   = explode(';', $request->f_d);
			list(, $data)       = explode(',', $data);
			$data = base64_decode($data);

			$fileName = "Pengesahan_".$proposal->student->user->name."_".$proposal->student->nim.'.pdf';
			$filePath = ($tahap == 2) ? "app/public/lembar_sah/ttd_sah/$fileName" : "app/public/lembar_sah/ttd_koor/$fileName";
			file_put_contents(storage_path($filePath), $data);

			$proposal->status_code = ($tahap == 2) ? Proposal::STATUS_Disahkan : Proposal::STATUS_Tunggu_TTDKajur;
			$proposal->lembar_sah = $fileName;
		}

		if($proposal->save()){
			if($tahap == 2){
				Storage::disk('public')->delete("lembar_sah/ttd_koor/{$proposal->lembar_sah}");
			}

			return redirect()
				->route('proposals.index')
				->with(['success' => 'Data berhasil diupdate!']);
		}
		else{
			return redirect()
				->route('proposals.index')
				->with(['failed' => 'Data gagal diupdate!']);
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Proposal  $proposal
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Proposal $proposal){
		//
	}
}
