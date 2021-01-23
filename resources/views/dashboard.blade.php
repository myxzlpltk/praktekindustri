@extends('layouts.app')

@section('title', "Dashboard")

@push('stylesheets')
@endpush

@section('content')
<div class="card shadow mb-4">
	@if(Auth::user()->role == "student")
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Pengajuan Proposal</h6>
	</div>
	<div class="card-body">
		<table class="table">
			<tr>
				<td>Status Pengajuan Proposal</td>
				<td>:</td>
				<td><a class="badge {{ Helper::proposalStatusClass($proposal->status_code ?? 0) }}">{{ $proposal->status ?? "Belum Mengajukan" }}</a></td>
			</tr>
			@if($proposal != null)
				@if(!in_array($proposal->status_code, [3,4]))
				<tr>
					<td>Tanggal Pengesahan</td>
					<td>:</td>
					<td><a class="badge badge-pill badge-primary">{{$proposal->tgl_sah_view}}</a></td>
				</tr>
				@endif
				<tr>
					<td>File Proposal</td>
					<td>:</td>
					<td><a href="{{ asset('storage/proposal/'.$proposal->file_proposal) }}">
						<i class="fas fa-file-alt mr-2"></i>
						{{$proposal->file_proposal}}
					</a></td>
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
			@endif
		</table>
	</div>
	@else
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Data Pengajuan Proposal</h6>
		</div>
		<div class="card-body">

			<h4 class="small font-weight-bold">Jumlah Akun Mahasiswa Terdaftar<span class="float-right">{{$statistik->total_mhs}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-primary" role="progressbar" style="width: {{($statistik->total_mhs / 427) * 100}}%" aria-valuenow="{{$statistik->total_mhs}}" aria-valuemin="0" aria-valuemax="427"></div>
			</div>

			<h4 class="small font-weight-bold">Total Proposal Disubmit <span class="float-right">{{$statistik->total_proposal}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-info" role="progressbar" style="width: {{($statistik->total_proposal / $statistik->total_mhs) * 100}}%" aria-valuenow="{{$statistik->total_proposal}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_mhs}}"></div>
			</div>

			<h4 class="small font-weight-bold">Proposal Menunggu Pengesahan Koordinator <span class="float-right">{{$statistik->pr_wait_koor}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-warning" role="progressbar" style="width: {{($statistik->pr_wait_koor / $statistik->total_proposal) * 100}}%" aria-valuenow="{{$statistik->pr_wait_koor}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_proposal}}"></div>
			</div>

			<h4 class="small font-weight-bold">Proposal Menunggu Pengesahan Ketua Jurusan <span class="float-right">{{$statistik->pr_wait_kajur}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-warning" role="progressbar" style="width: {{($statistik->pr_wait_kajur / $statistik->total_proposal) * 100}}%" aria-valuenow="{{$statistik->pr_wait_kajur}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_proposal}}"></div>
			</div>

			<h4 class="small font-weight-bold">Proposal Ditolak oleh Koordinator <span class="float-right">{{$statistik->pr_tolak_koor}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-danger" role="progressbar" style="width: {{($statistik->pr_tolak_koor / $statistik->total_proposal) * 100}}%" aria-valuenow="{{$statistik->pr_tolak_koor}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_proposal}}"></div>
			</div>

			<h4 class="small font-weight-bold">Proposal Ditolak oleh Ketua Jurusan <span class="float-right">{{$statistik->pr_tolak_kajur}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-danger" role="progressbar" style="width: {{($statistik->pr_tolak_kajur / $statistik->total_proposal) * 100}}%" aria-valuenow="{{$statistik->pr_tolak_kajur}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_proposal}}"></div>
			</div>

			<h4 class="small font-weight-bold">Proposal Disahkan <span class="float-right">{{$statistik->pr_acc}}</span></h4>
			<div class="progress mb-4">
				<div class="progress-bar bg-success" role="progressbar" style="width: {{($statistik->pr_acc / $statistik->total_proposal) * 100}}%" aria-valuenow="{{$statistik->pr_acc}}" aria-valuemin="0" aria-valuemax="{{$statistik->total_proposal}}"></div>
			</div>

			<p class="text-danger">Note: Jumlah proposal tidak sama dengan jumlah mahasiswa karena proposal yang ditolak juga diikutsertakan dalam data</p>
		</div>
	</div>
	@endif
</div>
@endsection

@push('scripts')
@endpush
