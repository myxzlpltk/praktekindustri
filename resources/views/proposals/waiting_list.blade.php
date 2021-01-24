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
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nama Mahasiswa</th>
							<th>Nama Industri/Instansi</th>
							<th>Tanggal Pengesahan</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
					@forelse ($proposals as $p)
						<tr role="row">
							<td>
								<a href="{{ route('students.show', $p->student) }}">{{$p->student->user->name}}</a>
								<small class="d-block text-muted">Dikirim {{ $p->created_at->translatedFormat('d M Y h:m') }}</small>
							</td>
							<td>{{$p->lokasi_prakerin}}</td>
							<td>{{$p->tgl_sah->translatedFormat('d F Y')}}</td>
							<td><a class="badge {{ Helper::proposalStatusClass($p->status_code) }}">{{ $p->status }}</a></td>
							<td><a class="btn btn-primary btn-sm" href="{{ route('proposals.show', $p) }}">Detail</a></td>
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
