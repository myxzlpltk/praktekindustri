@extends('layouts.app')

@section('title', "Pengajuan Proposal")

@push('stylesheets')
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Formulir</h6>
		</div>
		<div class="card-body">
			<form id="aju_form" action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
				@csrf

				<div class="form-group">
					<label for="lokasi">Nama Industri/Instansi</label>
					<input name="f_lokasi" type="text" class="form-control @error('f_lokasi') is-invalid @enderror" id="lokasi" value="{{ old('f_lokasi') }}" placeholder="Masukkan nama industri/instansi...">
					@error('f_lokasi')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group">
					<label for="tgl_sah">Tanggal Pengesahan (Hari Efektif)</label>
					<input name="f_tgl_sah" type="date" class="form-control @error('f_tgl_sah') is-invalid @enderror" id="tgl_sah" value="{{ old('f_tgl_sah') }}">
					@error('f_tgl_sah')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group">
					<label for="fileproposal">Unggah Proposal Berkas PI</label>
					<div class="custom-file @error('f_fileproposal') is-invalid @enderror">
						<input name="f_fileproposal" type="file" class="custom-file-input" id="fileproposal" accept="application/pdf">
						<label class="custom-file-label" for="fileproposal">Pilih Berkas</label>
					</div>

					@error('f_fileproposal')
					<div class="invalid-feedback d-block">{{ $message }}</div>
					@enderror
				</div>

				<a class="btn btn-primary text-white" onClick="getPreview()">Preview Lembar Pengesahan</a>

				<div id="v" style="overflow-x: scroll; overflow-y: hidden;">

				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script>

	var pdfjsLib = window['pdfjs-dist/build/pdf'];
	// The workerSrc property shall be specified.
	pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://mozilla.github.io/pdf.js/build/pdf.worker.js';

	function preview(location){
		function base64ToUint8Array(base64) {
			var raw = atob(base64);
			var uint8Array = new Uint8Array(raw.length);
			for (var i = 0; i < raw.length; i++) {
				uint8Array[i] = raw.charCodeAt(i);
			}
			return uint8Array;
		}

		var pdfData = base64ToUint8Array(location);
		// Using DocumentInitParameters object to load binary data.
		var loadingTask = pdfjsLib.getDocument({data: pdfData});
		var currPage = 1;
		var numPages = 0;
		var thePDF = null;

		loadingTask.promise.then(function(pdf) {
			thePDF = pdf;
			numPages = pdf.numPages;
			pdf.getPage(1).then(handlePages);
		});

		function handlePages(page){
			var canvas = document.createElement("canvas");
			const wrapper = document.getElementById('v');

			canvas.style.display = "block";
			canvas.id = "page-"+currPage;
			canvas.classList.add("pdf-view");
			let ctx = canvas.getContext('2d')
			let dpr = window.devicePixelRatio || 1
			let bsr = ctx.webkitBackingStorePixelRatio ||
				ctx.mozBackingStorePixelRatio ||
				ctx.msBackingStorePixelRatio ||
				ctx.oBackingStorePixelRatio ||
				ctx.backingStorePixelRatio || 1
			let ratio = dpr / bsr

			let originalviewport = page.getViewport({ scale: 1.5, });
			var viewport = page.getViewport({scale:screen.availWidth / originalviewport.width,})

			viewport = originalviewport
			canvas.width = viewport.width * ratio
			canvas.height = viewport.height * ratio
			canvas.style.width = viewport.width + 'px'
			canvas.style.height = viewport.height + 'px'
			//pc: 1.5 892.92 1262.835 1339 1894
			//mobile: 3 892.92 1262.835 2678 3788 ???
			console.log(ratio, viewport.width, viewport.height, canvas.width, canvas.height)
			ctx.setTransform(ratio, 0, 0, ratio, 0, 0)
			if(ratio > 1.5){
				ctx.scale(1/ratio, 1/ratio);
				wrapper.style.height = "500px";
			}

			const uploadBtn = document.createElement('input');
			uploadBtn.classList.add("btn");
			uploadBtn.classList.add("btn-block");
			uploadBtn.classList.add("btn-success");
			uploadBtn.name = "f_upload";
			uploadBtn.type = "submit";
			uploadBtn.id = "upBtn";
			uploadBtn.value="Submit Proposal";


			wrapper.appendChild(canvas);

			document.getElementById('aju_form').appendChild(uploadBtn);
			page.render({canvasContext: ctx, viewport: originalviewport});
		}
	}

	function getPreview() {
		const cek = document.getElementById('page-1');
		if(cek != null){
			cek.remove();
			document.getElementById("upBtn").remove();
		}
		const lokasi = document.getElementById('lokasi').value;
		const tgl_sah = document.getElementById('tgl_sah').value;
		if(lokasi.length <= 1 || tgl_sah.length <= 1){
			alert("Nama Industri/Instansi dan Tanggal Pengesahan Wajib Diisi!");
			return;
		}

		$.ajax({
			type:'POST',
			url:'/berkas',
			data:{
				_token: '{{ csrf_token() }}',
				lokasi_value: lokasi,
				tgl_sah_value: tgl_sah,
				prodi: {{ auth()->user()->student->prodi_id}}
			},
			success:function(data) {
				preview(data.preview)
			}
		});
	}
</script>
@endpush
