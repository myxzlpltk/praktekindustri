@extends('layouts.app')

@section('title', "Dashboard")

@push('stylesheets')
@endpush

@section('content')
<div class="card shadow mb-4">
	@if($proposal != null)
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Status Pengajuan</h6>
	</div>
	<div class="card-body">
		<table class="table">
			<tr>
				<td>Status Pengajuan Proposal</td>
				<td>:</td>
				<td><a class="badge {{ Helper::proposalStatusClass($proposal->status_code) }}">{{ $proposal->status }}</a></td>
			</tr>
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
		</table>
	</div>
	@endif
</div>
@endsection

@push('scripts')
@endpush
