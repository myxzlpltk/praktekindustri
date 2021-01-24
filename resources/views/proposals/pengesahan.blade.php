@extends('layouts.app')

@section('title', "Pengesahan Proposal")

@push('stylesheets')
@can('update', $proposal)
<style>
::-webkit-scrollbar {
    -webkit-appearance: none;
}

::-webkit-scrollbar:vertical {
    width: 12px;
}

::-webkit-scrollbar:horizontal {
    height: 12px;
}

::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, .5);
    border-radius: 10px;
    border: 2px solid #ffffff;
}

::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #ffffff;
}
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.0/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.2.0/fabric.min.js" integrity="sha512-Pdu3zoEng2TLwwjnDne3O7zaeWZfEJHU5B63T+zLtME/wg1zfeSH/1wrtOzOC37u2Y1Ki8pTCdKsnbueOlFlMg==" crossorigin="anonymous"></script>
<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script>
(function(){
  var defaultOnTouchStartHandler = fabric.Canvas.prototype._onTouchStart;
  fabric.util.object.extend(fabric.Canvas.prototype, {
    _onTouchStart: function(e) {
      var target = this.findTarget(e);
      // if allowTouchScrolling is enabled, no object was at the
      // the touch position and we're not in drawing mode, then
      // let the event skip the fabricjs canvas and do default
      // behavior
      if (this.allowTouchScrolling && !target && !this.isDrawingMode) {
        // returning here should allow the event to propagate and be handled
        // normally by the browser
        return;
      }

      // otherwise call the default behavior
      defaultOnTouchStartHandler.call(this, e);
    }
  });
})();

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
									console.log("Ratio: ", ratio);

									let originalviewport = page.getViewport({ scale: 1.5, });
									var viewport = page.getViewport({scale:screen.availWidth / originalviewport.width,})
									console.log("o.V", originalviewport);
									viewport = originalviewport
									console.log("v", viewport);
									//------------JANGAN SENTUH-------------------//
									canvas.width = 1339 //viewport.width * ratio
									canvas.height = 1894 //viewport.height * ratio
									canvas.style.width = 892.92 + 'px'
									canvas.style.height = 1262.84 + 'px' //viewport.height + 'px'
									ctx.setTransform(1.5, 0, 0, 1.5, 0, 0)
									//------------./JANGAN SENTUH-------------------//

									//ctx.setTransform(ratio, 0, 0, ratio, 0, 0)
									/*console.log("C.w: ", canvas.width);
									console.log("C.h: ", canvas.height);
									console.log("C.s.w: ", canvas.style.width);
									console.log("C.s.h: ", canvas.style.height);*/

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
									f_canvas = new fabric.Canvas('page-1',
									{
										selection: false,
										allowTouchScrolling: true
									});
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

			var doc = new jsPDF('p', 'mm');
			var position = 0;

			doc.addImage(canvas, 'PNG', 0, position, imgWidth, imgHeight, undefined, 'FAST');
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
									scaleY: f_canvas.height/bg.height,
							});
					});
					f_canvas.setBackgroundImage(bg);
					ori_canvas = false;
				}
				fabric.Image.fromURL(e.target.result, function(oImg) {
							oImg.set({
								top: 800,
								@if($proposal->status_code == 1)
								left: 560,
								@elseif($proposal->status_code == 2)
								left: 200,
								@endif
								scaleX: 215/oImg.width,
								scaleY: 145/oImg.height,
								selectable: true
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
					<td><a href="{{ route('students.show', $proposal->student) }}">{{$proposal->student->user->name}}</a></td>
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
					<td>{{$proposal->tgl_sah->translatedFormat('d F Y')}}</td>
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
				@if(in_array($proposal->status_code, [3,4]))
				<tr>
					<td>Alasan Penolakan</td>
					<td>:</td>
					<td class="text-danger">{{$proposal->alasanKajur ?? $proposal->alasanKoor}}</td>
				</tr>
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
