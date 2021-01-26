@extends('layouts.app')

@section('title', "Data Koordinator")

@push('stylesheets')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@section('actions')
	@can('create', \App\Models\Coordinator::class)
		<a href="{{ route('coordinators.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-fw"></i> Tambah Koordinator</a>
	@endcan
@endsection

@section('content')
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table dataTable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Nomor ID</th>
							<th>Prodi</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
					@foreach($coordinators as $coordinator)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $coordinator->name }}</td>
							<td>{{ $coordinator->id_type }} {{ $coordinator->id_number }}</td>
							<td>
								<ul class="list-unstyled">
								@foreach($coordinator->prodi as $prodi)
									<li><a href="{{ route('prodi.show', $prodi) }}">{{ $prodi->name }}</a></li>
								@endforeach
								</ul>
							</td>
							<td>
								@can('view', $coordinator)
									<a href="{{ route('coordinators.show', $coordinator) }}" class="btn btn-primary btn-sm">Lihat</a>
								@endcan
							</td>
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

