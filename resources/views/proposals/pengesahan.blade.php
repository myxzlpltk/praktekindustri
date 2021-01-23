@extends('layouts.app')

@section('title', "Pengesahan Proposal")

@push('stylesheets')
@can('update', $proposal)
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.2.0/fabric.min.js" integrity="sha512-Pdu3zoEng2TLwwjnDne3O7zaeWZfEJHU5B63T+zLtME/wg1zfeSH/1wrtOzOC37u2Y1Ki8pTCdKsnbueOlFlMg==" crossorigin="anonymous"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
	var f_canvas;
	var ori_canvas = true;

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


									const ttdBtn = document.createElement('a');
									ttdBtn.classList.add("btn");
									ttdBtn.classList.add("btn-block");
									ttdBtn.classList.add("btn-secondary");
									ttdBtn.innerHTML="Masukkan Tanda Tangan";
									ttdBtn.onclick = () => {$("#ttdInp").click()};

									const uploadBtn = document.createElement('a');
									uploadBtn.classList.add("btn");
									uploadBtn.classList.add("btn-block");
									uploadBtn.classList.add("btn-success");
									uploadBtn.classList.add("disabled");
									//uploadBtn.name = "f_upload";
									uploadBtn.id = 'upload_btn'
									//uploadBtn.type = "submit";
									uploadBtn.onclick = () => {getPDF()}
									uploadBtn.innerHTML="Konfirmasi Tanda Tangan";


									const wrapper = document.getElementById('v');

									wrapper.appendChild(ttdBtn);
									wrapper.appendChild(uploadBtn);
									wrapper.appendChild(canvas);

									page.render({canvasContext: ctx, viewport: originalviewport});
									f_canvas = new fabric.Canvas('page-1');
									document.getElementById('wait_text').remove();
							}
			}

			function getPreview() {
				const wait = document.createElement('p');
				wait.classList.add('mt-2');
				wait.classList.add('text-danger');
				wait.innerHTML = "Mohon Tunggu... Jika selama 15 detik tidak muncul, silahkan reload dan coba kembali.";
				wait.id = 'wait_text';
				document.getElementById('valid_btn').classList.add('disabled');
				document.getElementById('tolak_btn').classList.add('disabled');
				document.getElementById('v').appendChild(wait);
				if(f_canvas != null){
					document.getElementById('page-1').remove();
					f_canvas = null;
				}

				const lokasi = "{{$proposal->lokasi_prakerin}}";
				const tgl_sah = '{{$proposal->tgl_sah}}';

				@if($proposal->status_code == 1)
				$.ajax({
						type:'POST',
						url:'/berkas',
						data:{_token: $('input[name ="_token"]').val(),
									lokasi_value: lokasi,
									tgl_sah_value: tgl_sah,
									ttd: "koor",
									prodi: {{$proposal->student->prodi_id}}
								},
						success:function(data) {
							preview(data.preview)
						}
				});
				@elseif($proposal->status_code == 2)
				$.ajax({
						type:'POST',
						url:'/berkas',
						data:{_token: $('input[name ="_token"]').val(),
									lokasi_value: lokasi,
									tgl_sah_value: tgl_sah,
									ttd: "kajur",
									fileName: "{{$proposal->lembar_sah}}",
									prodi: {{$proposal->student->prodi_id}}
								},
						success:function(data) {
							preview(data.preview)
						}
				});
				@endif
		}

		function getPDF(){
			f_canvas.discardActiveObject().renderAll();
			var canvas = document.getElementsByClassName('pdf-view')[0]
			var imgWidth = 300;
			var pageHeight = 300;
			var imgHeight = canvas.height * imgWidth / canvas.width;
			var heightLeft = imgHeight;
			var imgData = canvas.toDataURL("image/png", 1.0);

			var doc = new jsPDF('p', 'mm');
			var position = 0;

			doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight, undefined, 'FAST');
			heightLeft -= pageHeight;
			document.getElementById('d').value = doc.output('datauristring');
			document.getElementById('p_st').value = "valid";
			document.getElementById('sah_form').submit();
	}

	function readURL(input) {
		const uploadBtn = document.getElementById('upload_btn');
		if(uploadBtn.classList.contains('disabled')){
			uploadBtn.classList.remove('disabled');
		}
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				if(ori_canvas){
					var bg = new fabric.Image();
					bg.setSrc(document.getElementsByClassName('pdf-view')[0].toDataURL("image/png"), () => {
							bg.set({
									top: 0,
									left: 0,
									scaleX: f_canvas.width/bg.width,
									scaleY: f_canvas.height/bg.height
							});
					});
					f_canvas.setBackgroundImage(bg);
					ori_canvas = false;
				}
				fabric.Image.fromURL(e.target.result, function(oImg) {
							oImg.set({
								top: 750,
								left: 570
							});
							f_canvas.add(oImg);
					});
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	</script>
@endcan
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Detail Pengajuan</h6>
		</div>
		<div class="card-body">
			<table class="table table-responsive">
				<tr>
					<th>Nama</th>
					<td>:</td>
					<td>{{$proposal->student->user->name}}</td>
				</tr>
				<tr>
					<th>NIM</th>
					<td>:</td>
					<td>{{$proposal->student->nim}}</td>
				</tr>
				<tr>
					<th>Prodi</th>
					<td>:</td>
					<td>{{$proposal->student->prodi->name}}</td>
				</tr>
				<tr>
					<th>Nama Industri/Instansi</th>
					<td>:</td>
					<td>{{$proposal->lokasi_prakerin}}</td>
				</tr>
				<tr>
					<th>Tanggal Pengesahan</th>
					<td>:</td>
					<td>{{$proposal->tgl_sah_view}}</td>
				</tr>
				<tr>
					<th>File Proposal PI</th>
					<td>:</td>
					<td><a href="{{ asset('storage/proposal/'.$proposal->file_proposal) }}">
						<i class="fas fa-file-alt mr-2"></i>
						{{$proposal->file_proposal}}
					</a></td>
				</tr>
				<tr>
					<th>Status</th>
					<td>:</td>
					<td><a class="badge {{ Helper::proposalStatusClass($proposal->status_code) }}">{{ $proposal->status }}</a></td>
				</tr>
				@if($proposal->status_code == 5)
					<tr>
						<th>Lembar Pengesahan</th>
						<td>:</td>
						<td><a href="{{ asset('storage/lembar_sah/ttd_sah/'.$proposal->lembar_sah) }}">
							<i class="fas fa-file-alt mr-2"></i>
							{{$proposal->lembar_sah}}
						</a></td>
					</tr>
				@endif
				@if(in_array($proposal->status_code, [3,4], true ))
					<th>Alasan Penolakan</th>
					<td>:</td>
					@if($proposal->status_code == 3)
						<td class="text-danger">{{$proposal->alasanKoor}}</td>
					@elseif($proposal->status_code == 4)
						<td class="text-danger">{{$proposal->alasanKajur}}</td>
					@endif
				@endif
			</table>
			<div id="b">
				<input id="ttdInp" style="display: none;" type="file" accept="image/*" onchange="readURL(this)">
			</div>

			@can('update', $proposal)
			<a class="btn btn-success text-white" id="valid_btn" onClick="getPreview()">Validasi</a>
			<a class="btn btn-danger text-white" id="tolak_btn" onClick="getTolak()">Tolak</a>

			<form action="{{ route('proposals.update', $proposal->id) }}" id="sah_form" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PUT')
				<input id="d" name="f_d" style="display: none;" name="f_d" type="text"> {{---pdf data uri---}}
				<input id="p_st" name="f_p_st" style="display: none;" type="hidden" value="tolak"> {{---validasi/tolak---}}
				<div id="tolak_form" class="form-group mt-3" style="display: none;" >
					<label class="text-danger text-bold">Alasan Penolakan:</label>
					<input type="text" class="form-control is-invalid" name="f_alasan" placeholder="Masukkan alasan penolakan...">
					<input type="submit" class="btn btn-danger btn-block mt-2" value="Tolak Proposal">
				</div>
			</form>


			<div id="v" class="mt-3" style="overflow-x: scroll;">

			</div>
			@endcan
		</div>
	</div>
@endsection

@push('scripts')
<script>
	function getTolak(){
		document.getElementById('valid_btn').classList.add('disabled');
		document.getElementById('tolak_btn').classList.add('disabled');
		document.getElementById('tolak_form').style.removeProperty('display');
		document.getElementById('p_st').value = "tolak";
	}
</script>
@endpush
