@extends('layouts.app')

@section('title', "Dashboard")

@push('stylesheets')
@endpush

@section('content')
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Status Pengajuan</h6>
	</div>
	<div class="card-body">
		<table class="table">
			<tr>
				<td>Status Pengajuan Proposal</td>
				<td>:</td>
				<td><a class="badge badge-pill badge-secondary">Belum mengajukan</a></td>
			</tr>
			<tr>
				<td>Tanggal Pengesahan</td>
				<td>:</td>
				<td><a class="badge badge-pill badge-primary">24 Juni 2002</a></td>
			</tr>
			<tr>
				<td>File Proposal</td>
				<td>:</td>
				<td><a href="#"><i class="fas fa-file-alt mr-2"></i>Filename.pdf</a></td>
			</tr>
			<tr>
				<td>Lembar Pengesahan</td>
				<td>:</td>
				<td><a href="#"><i class="fa fa-file-download mr-2"></i>Filename.pdf</a></td>
			</tr>
			<tr>
				<td>Alasan Penolakan</td>
				<td>:</td>
				<td class="text-danger">Filename.pdf</td>
			</tr>
		</table>
	</div>
</div>
@endsection

@push('scripts')
@endpush
