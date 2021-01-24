@extends('layouts.app')

@section('title', $student->name)

@push('stylesheets')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Mahasiswa</h6>
			@can('delete', $student)
			<form action="{{ route('students.destroy', $student) }}" method="POST">
				@csrf
				@method('DELETE')
				<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i> Hapus</button>
			</form>
			@endcan
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3">
					<div class="thumbnail rounded-circle mx-auto shadow mb-4">
						<img src="https://api.um.ac.id/akademik/operasional/GetFoto.ptikUM?nim={{ $student->nim }}&angkatan={{ $student->angkatan }}" alt="Photo">
					</div>
				</div>
				<div class="col-md-9">
					<table class="table table-sm">
						<tr>
							<th>Nomor Induk Mahasiswa</th>
							<td>{{ $student->nim }}</td>
						</tr>
						<tr>
							<th>Nama Lengkap</th>
							<td>{{ $student->name }}</td>
						</tr>
						<tr>
							<th>Program Studi</th>
							<td>{{ optional($student->prodi)->name }}</td>
						</tr>
						<tr>
							<th>Tahun Angkatan</th>
							<td>{{ $student->angkatan }}</td>
						</tr>
						<tr>
							<th>Alamat Email</th>
							<td>
								{{ $student->user->email }}
								@if($student->user->hasVerifiedEmail())
									<i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" title="Terverifikasi"></i>
								@else
									<i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" title="Tidak Terverifikasi"></i>
								@endif
							</td>
						</tr>
						<tr>
							<th>Tanggal Pendaftaran</th>
							<td>{{ $student->created_at }}</td>
						</tr>
						<tr>
							<th>Scan KTM</th>
							<td>
								<a href="{{ asset('storage/ktm/'.$student->ktm) }}" target="_blank">Lihat KTM <i class="fa fa-external-link-alt fa-fw"></i></a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
		@can('reset-password', $student)
		<div class="card-footer">
			<form action="{{ route('students.reset-password', $student) }}" method="POST">
				@csrf
				@method('PATCH')
				<button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-key fa-fw"></i> Reset Kata Sandi</button>
			</form>
		</div>
		@endcan
	</div>

	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Proposal</h6>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered dataTable" id="dataTable">
					<thead>
						<tr>
							<th>Nama Industri/Instansi</th>
							<th>Tanggal Pengesahan</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($student->proposals as $proposal)
						<tr>
							<td>{{ $proposal->lokasi_prakerin }}</td>
							<td>{{ $proposal->tgl_sah->translatedFormat('d F Y') }}</td>
							<td><a class="badge {{ Helper::proposalStatusClass($proposal->status_code) }}">{{ $proposal->status }}</a></td>
							<td><a class="btn btn-primary btn-sm" href="{{ route('proposals.show', $proposal) }}">Detail</a></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush
