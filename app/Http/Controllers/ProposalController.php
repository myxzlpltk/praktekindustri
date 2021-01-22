<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;

class ProposalController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
			$proposals = Proposal::latest()->paginate(10);
			return view('proposals.waiting_list', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
			/*
    	$data = [
    		'tempat' => 'Bappeda Malang',
				'tanggal' => now()->translatedFormat('d F Y'),
				'nama_kajur' => config('settings.nama_kajur'),
				'nip_kajur' => config('settings.nip_kajur'),
				'nama_koor' => config('settings.nama_koor'),
				'nip_koor' => config('settings.nip_koor'),
			];

    	$templateProcessor = new TemplateProcessor(storage_path('templates/lembar_pengesahan_proposal_pi.docx'));
			$templateProcessor->setValues($data);
			$templateProcessor->setImageValue('ttd_kajur', storage_path('templates/kajur_signature.png'));

			$rand = Str::random(16);
			$fileName = "$rand.docx";
			$pathFile = storage_path("app/public/tmp/$fileName");
			$templateProcessor->saveAs($pathFile);

			return response()->download("storage/tmp/$fileName")->deleteFileAfterSend();*/


    	return view('proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
			if($request->session()->has('preview_pathfile')){
				Storage::disk('local')->delete(session('preview_pathfile'));
				$request->session()->forget('preview_pathfile');
			}
			$this->validate($request, [
        'f_fileproposal'     => 'required|mimes:pdf',
        'f_lokasi'     => 'required',
				'f_tgl_sah'   => 'required',
			]);


			$file_proposal = $request->file('f_fileproposal');
			$file_proposal->storeAs("proposal/", $file_proposal->getClientOriginalName());

			$proposal = new Proposal;
			$proposal->file_proposal = $file_proposal->getClientOriginalName();
			$proposal->lokasi_prakerin = $request->f_lokasi;
			$proposal->tgl_sah = $request->f_tgl_sah;
			$proposal->status = 'Tunggu_TTD';
			$proposal->user_id = 1; //to-be replaced later


			if($proposal->save()){
				return redirect()->route('proposals.index')->with(['success' => 'Data Berhasil Disimpan!']);
			} else{
				return redirect()->route('proposals.create')->with(['failed' => 'Terjadi Kesalahan!']);
			}
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal){

        return view('proposals.pengesahan', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal){
				$pr = Proposal::find($proposal->id);
				if($request->f_p_st == "tolak"){
					$pr->status= "Ditolak_Koor";
					$pr->alasanKoor = $request->f_alasan;
				} else if($request->f_p_st == "valid"){
					list($ext, $data)   = explode(';', $request->f_d);
					list(, $data)       = explode(',', $data);
					$data = base64_decode($data);

					$fileName = $pr->user->name.'.pdf';
					file_put_contents(storage_path("app/public/lembar_sah/ttd_koor/$fileName"), $data);

					$pr->status = "Tunggu_TTDKajur";
					$pr->lembar_sah = $fileName;
				}

				if($pr->save()){
						return redirect()->route('proposals.index')->with(['success' => 'Data berhasil diupdate!']);
				} else{
						return redirect()->route('proposals.index')->with(['failed' => 'Data gagal diupdate!']);
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
