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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal){
        //
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
