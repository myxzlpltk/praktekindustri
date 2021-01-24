@extends('layouts.app')

@section('title', "Data Mahasiswa Terdaftar")

@push('stylesheets')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				{{ $dataTable->table() }}
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
	{{ $dataTable->scripts() }}
@endpush
