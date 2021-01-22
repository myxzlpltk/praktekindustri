<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class PdfmakerController extends Controller
{
		/**
	 * Provision a new web server.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
    public function __invoke()
    {
        // ...
    }
	public function index($lokasi, $tgl_sah){
		$today = Carbon::parse($tgl_sah)->isoFormat('D MMMM Y');

		$fpdf = new Fpdf('P', 'mm', 'A4');
		$fpdf->AddPage();
		$fpdf->SetFont('Times', 'B', 14);
		$fpdf->Cell(0, 30, '', 0, 1.15);
		$fpdf->Image('./img/border-pdf.png', 50, $fpdf->getY(), 130, 3);
		$fpdf->Cell(210, 50, 'LEMBAR PENGESAHAN', 0, 1.15, 'C');
		$fpdf->SetFont('Times', '', 12);
		$fpdf->Cell(40, 30, '', 0);
		$fpdf->MultiCell(130, 6, 'Proposal Praktik Industri ini telah diperiksa dan disetujui oleh Koordinator Praktik Industri Jurusan Teknik Elektro - Fakultas Teknik - Universitas Negeri Malang, sebagai kelengkapan berkas permohonan ijin melaksanakan Praktik Industri ke '.$lokasi);
		$fpdf->Cell(170, 30, 'Malang, '.$today, 0, 1.15, 'R');
		$fpdf->SetFont('Times', 'B', 12);
		$fpdf->Cell(210, 20, 'Menyetujui,', 0, 1.15, 'C');
		$fpdf->SetFont('Times', '', 12);
		$fpdf->Cell(40, 0, '', 0);
		$xKet = $fpdf->getX();
		$fpdf->Cell(75, 45, 'Ketua Jurusan Teknik Elektro,', 0, 0);
		$fpdf->setX($fpdf->getX()+5);
		$fpdf->Cell(75, 45, 'Koordinator Praktik Industri,', 0, 1.15);
		$fpdf->Cell(-75);
		//$fpdf->Cell(40, 0, '', 1);
		$y = $fpdf->getY();
		$fpdf->setX($xKet);
		$fpdf->MultiCell(75, 6, 'Aji Prasetya Wibawa, S.T., M.M.T., Ph.D. NIP 197912182005011001', 0, 'L');
		$x = $fpdf->getX();

		$fpdf->SetXY($x+120, $y);
		//$fpdf->MultiCell(70, 6, 'Kartika Candra Kirana, S.Pd., M. Kom NIP 199105012019032030', 0, 'L');
		$fpdf->MultiCell(59, 6, 'Achmad Hamdan, S.Pd., M.Pd. NITP 6400201819443', 0, 'L');
		$fpdf->Image('./img/border-pdf.png', 50, $fpdf->getY() + 30, 130, 3);
		$rand = Str::random(16);
		$fileName = "$rand.pdf";
		$pathFile = storage_path("app/public/tmp/$fileName");

		$fpdf->Output('F',$pathFile);
		session(['preview_pathfile' => "public/tmp/$fileName"]);
		$b64Doc = chunk_split(base64_encode(file_get_contents($pathFile)));
		return $b64Doc;

		}

		public function store(Request $request){
			if($request->session()->has('preview_pathfile')){
				Storage::disk('local')->delete(session('preview_pathfile'));
				$request->session()->forget('preview_pathfile');
			}

			$fileName = $this->index($request->lokasi_value, $request->tgl_sah_value);
			return response()->json(array('preview'=> $fileName), 200);
		}
}
