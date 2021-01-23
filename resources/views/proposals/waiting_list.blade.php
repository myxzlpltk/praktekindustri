@extends('layouts.app')

@section('title', "Daftar Tunggu Proposal")

@push('stylesheets')
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-clipboard-list fa-fw"></i>Daftar Tunggu Proposal</h6>
		</div>
		<div class="card-body">

			@if(session()->has('success'))
				<div class="alert alert-success">
					{{session('success')}}
				</div>
			@elseif(session()->has('failed'))
				<div class="alert alert-danger">
					{{session('failed')}}
				</div>
			@endif
			<div class="table-responsive">
				<table class="table table-bordered" width="100%" style="width: 100%;">
					<thead>
						<tr role="row">
							<th style="width: 38px;">Nama Mahasiswa</th>
							<th style="width: 61px;">Nama Industri/Instansi</th>
							<th style="width: 50px;">Tanggal Pengesahan</th>
							<th style="width: 50px;">Status</th>
							<th style="width: 50px;">Detail</th>
						</tr>
					</thead>
					<tbody>
					@forelse ($proposals as $p)
						<tr role="row">
							<td>{{$p->student->user->name}}</td>
							<td>{{$p->lokasi_prakerin}}</td>
							<td>{{$p->tgl_sah_view}}</td>
							<td><a class="badge {{ Helper::proposalStatusClass($p->status_code) }}">{{ $p->status }}</a></td>
							<td><a class="btn btn-primary btn-sm" href="{{ route('proposals.show', $p->id) }}">Detail</a></td>
						</tr>
					@empty
						<tr>
							<td colspan="5" align="center"><span class="text-muted">Data tidak ditemukan</span></td>
						</tr>
					@endforelse
					</tbody>
				</table>
			</div>
			<div class="d-flex justify-content-center">
				{{ $proposals->links() }}
			</div>

		</div>
	</div>
@endsection

@push('scripts')

@endpush
