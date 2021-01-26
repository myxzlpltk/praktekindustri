@extends('layouts.app')

@section('title', $coordinator->name)

@push('stylesheets')
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Koordinator</h6>
			<div>
				@can('update', $coordinator)
					<a href="{{ route('coordinators.edit', $coordinator) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
				@endcan

				@can('delete', $coordinator)
					<form action="{{ route('coordinators.destroy', $coordinator) }}" method="POST" class="d-inline-block">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-fw"></i> Hapus</button>
					</form>
				@endcan
			</div>
		</div>
		<div class="card-body">
			<table class="table table-borderless table-sm">
				<tr>
					<th>Username</th>
					<td>{{ $coordinator->user->username }}</td>
				</tr>
				<tr>
					<th>Nama Lengkap</th>
					<td>{{ $coordinator->name }}</td>
				</tr>
				<tr>
					<th>Nomor Identifikasi</th>
					<td>{{ $coordinator->id_type }} {{ $coordinator->id_number }}</td>
				</tr>
				<tr>
					<th>Program Studi</th>
					<td>
						<ul class="list-unstyled">
							@foreach($coordinator->prodi as $prodi)
								<li><a href="{{ route('prodi.show', $prodi) }}">{{ $prodi->name }}</a></li>
							@endforeach
						</ul>
					</td>
				</tr>
				<tr>
					<th>Alamat Email</th>
					<td>
						{{ $coordinator->user->email }}
						@if($coordinator->user->hasVerifiedEmail())
							<i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" title="Terverifikasi"></i>
						@else
							<i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" title="Tidak Terverifikasi"></i>
						@endif
					</td>
				</tr>
				<tr>
					<th>Tanggal Pendaftaran</th>
					<td>{{ $coordinator->created_at }}</td>
				</tr>
			</table>
		</div>
		<div class="card-footer">
			@can('reset-password', $coordinator)
			<form action="{{ route('coordinators.reset-password', $coordinator) }}" method="POST">
				@csrf
				@method('PATCH')
				<button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-key fa-fw"></i> Reset Kata Sandi</button>
			</form>
			@endcan
		</div>
	</div>
@endsection

@push('scripts')
@endpush
