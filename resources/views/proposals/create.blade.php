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
			<form action="{{ route('proposals.store') }}" method="POST" enctype="multipart/form-data">
				@csrf

				<div class="form-group">
					@error('f_lokasi')
					<div class="alert alert-danger mb-2">
							Nama industri/instansi wajib diisi!
					</div>
					@enderror
					<label for="lokasi">Nama Industri/Instansi</label>
					<input name="f_lokasi" type="text" class="form-control form-control-user" id="lokasi" value="{{ old('f_lokasi') }}" placeholder="Masukkan nama industri/instansi...">
				</div>
				<div class="form-group">
					@error('f_tgl_sah')
					<div class="alert alert-danger mb-2">
							Tanggal pengesahan wajib diisi!
					</div>
					@enderror
					<label for="tgl_sah">Tanggal Pengesahan (Hari Efektif)</label>
					<input name="f_tgl_sah" type="date" class="form-control form-control-user" id="tgl_sah" value="{{ old('f_tgl_sah') }}">
				</div>
				<div class="form-group">
					@error('f_fileproposal')
					<div class="alert alert-danger mb-2">
							Proposal wajib diunggah dalam format pdf!
					</div>
					@enderror
					<label for="fileproposal">Unggah Proposal Berkas PI</label>
					<input name="f_fileproposal" type="file" class="form-control form-control-user" id="fileproposal" accept="application/pdf">
				</div>
				<a class="btn btn-primary text-white" onClick="getPreview()">Preview Lembar Pengesahan</a>
				<div id="v">

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
                var viewport = page.getViewport({scale: 1});
                var canvas = document.createElement("canvas");
                var canvasCtx = canvas.getContext('2d')

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
                ctx.setTransform(ratio, 0, 0, ratio, 0, 0)

								const uploadBtn = document.createElement('input');
								uploadBtn.classList.add("btn");
								uploadBtn.classList.add("btn-block");
								uploadBtn.classList.add("btn-success");
								uploadBtn.name = "f_upload";
								uploadBtn.type = "submit";
								uploadBtn.value="Submit Proposal";

								const wrapper = document.getElementById('v');
                wrapper.appendChild(canvas);
								wrapper.appendChild(uploadBtn);

                page.render({canvasContext: ctx, viewport: originalviewport});
						}
		}

		function getPreview() {
			const lokasi = document.getElementById('lokasi').value;
			const tgl_sah = document.getElementById('tgl_sah').value;
			//alert(tgl_sah);

			//var lokasi = "Google"
			//var tgl_sah = "01-02-2021"
			if(lokasi.length <= 1 || tgl_sah.length <= 1){

				alert("Nama Industri/Instansi dan Tanggal Pengesahan Wajib Diisi!");
				return;
			}

			$.ajax({
					type:'POST',
					url:'/berkas',
					data:{_token: $('input[name ="_token"]').val(),
								lokasi_value: lokasi,
								tgl_sah_value: tgl_sah},
					success:function(data) {
						preview(data.preview)
					}
			});
	}
</script>
@endpush
