@extends('layouts.app')

@section('title', "Edit Konfigurasi")

@push('stylesheets')
@endpush

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Formulir</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('settings.update', $setting) }}" method="POST">
				@csrf
				@method('PATCH')

				<div class="form-group">
					<label for="">Key</label>
					<input type="text" class="form-control" value="{{ $setting->key }}" readonly>
				</div>
				<div class="form-group">
					<label for="description">Deskripsi</label>
					<input type="text" name="description" class="form-control @error('description') is-invalid @enderror" id="description" value="{{ old('description', $setting->description) }}">
					@error('description')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group">
					<label for="value">Value</label>
					<input type="text" name="value" class="form-control @error('value') is-invalid @enderror" id="value" value="{{ old('value', $setting->value) }}" autofocus>
					@error('value')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>

				<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
@endpush
