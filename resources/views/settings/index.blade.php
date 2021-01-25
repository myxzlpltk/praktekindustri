@extends('layouts.app')

@section('title', "Konfigurasi")

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
							<th>Key</th>
							<th>Nilai</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach($settings as $setting)
						<tr>
							<td>{{ $loop->iteration }}</td>
							<td>
								<strong>{{ $setting->key }}</strong>
								<small class="d-block text-primary">{{ $setting->description }}</small>
							</td>
							<td>{{ $setting->value }}</td>
							<td>
								@can('update', $setting)
								<a href="{{ route('settings.edit', $setting) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-fw"></i> Edit</a>
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
