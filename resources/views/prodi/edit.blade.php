@extends('layouts.app')

@section('title', "Edit Koordinator")

@push('stylesheets')
@endpush

@section('actions')

@endsection

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Formulir</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('prodi.update', $prodi) }}" method="POST">
				@csrf
				@method('PATCH')

				<div class="form-group">
					<label for="coordinator_id">Koordinator</label>
					<select name="coordinator_id" class="form-control @error('coordinator_id') is-invalid @enderror" id="coordinator_id" required>
						<option disabled selected>-- Pilih Koordinator --</option>
						@foreach($coordinators as $coordinator)
						<option value="{{ $coordinator->id }}" @if(old('coordinator_id', $prodi->coordinator->id) == $coordinator->id) selected @endif>{{ $coordinator->name }}</option>
						@endforeach
					</select>
					@error('coordinator_id')
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
