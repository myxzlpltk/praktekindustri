@extends('layouts.app')

@section('title', "Pendaftaran Proposal")

@push('stylesheets')
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

									const uploadBtn = document.createElement('input');
									uploadBtn.classList.add("btn");
									uploadBtn.classList.add("btn-block");
									uploadBtn.classList.add("btn-success");
									uploadBtn.name = "f_upload";
									uploadBtn.type = "submit";
									uploadBtn.value="Sahkan Proposal";


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

		function getPDF(){
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
			doc.save( 'file.pdf');
	}

		function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				console.log(e.target.result);
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
							f_canvas.add(oImg);
					});
			}

			reader.readAsDataURL(input.files[0]); // convert to base64 string
		}
	}

	$("#ttdInp").change(function() {
		readURL(this);
	});
	</script>
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Formulir</h6>
		</div>
		<div class="card-body">
			<form action="#" method="POST" enctype="multipart/form-data">
				@csrf

				<a class="btn btn-primary text-white" id="valid_btn" onClick="getPreview()">Validasi</a>
				<a class="btn btn-primary text-white" id="tolak_btn" onClick="getTolak()">Tolak</a>
				<div id="b">
					<input id="ttdInp" style="display: none;" type="file" accept="image/*">
				</div>
				<div id="v">

				</div>
			</form>
		</div>
	</div>
@endsection

@push('scripts')


@endpush
