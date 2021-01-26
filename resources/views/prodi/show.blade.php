@extends('layouts.app')

@section('title', "Data Mahasiswa $prodi->name")

@push('stylesheets')
	<link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush

@section('actions')
	@can('update', $prodi)
		<a href="{{ route('prodi.edit', $prodi) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit fa-fw"></i> Edit Koordinator</a>
	@endcan
@endsection

@section('content')
	<div class="alert alert-info" role="alert">
		<span>Koordinator : </span>
		<b><a href="{{ route('coordinators.show', $prodi->coordinator) }}">{{ $prodi->coordinator->name }}</a></b>
	</div>

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
