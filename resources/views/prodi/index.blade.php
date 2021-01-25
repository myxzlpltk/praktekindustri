@extends('layouts.app')

@section('title', "Data Program Studi")

@push('stylesheets')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table dataTable">
					<thead>
						<tr>
							<th>No.</th>
							<th>Nama</th>
							<th>Kode</th>
							<th>Koordinator</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($prodis as $prodi)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>{{ $prodi->name }}</td>
							<td>{{ $prodi->code }}</td>
							<td>{{ $prodi->coordinator->name }}</td>
							<td>
								@can('view', $prodi)
								<a href="{{ route('prodi.show', $prodi) }}" class="btn btn-primary btn-sm">Lihat</a>
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
