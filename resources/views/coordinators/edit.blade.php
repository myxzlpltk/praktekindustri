@extends('layouts.app')

@section('title', "Edit Koordinator")

@push('stylesheets')
@endpush

@section('actions')

@endsection

@section('content')
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Nomor Identifikasi</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('coordinators.update', $coordinator) }}" method="POST" enctype="multipart/form-data">
				@csrf
				@method('PATCH')

				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label class="form-control-label" for="input-name">Nama Lengkap <x-required/></label>
							<input type="text" id="input-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name', $coordinator->user->name) }}" required>
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="form-control-label" for="input-email">Email address <x-required/></label>
							<input type="email" id="input-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email', $coordinator->user->email) }}" required>
							@error('email')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-3">
						<div class="form-group">
							<label class="form-control-label" for="id_type">Tipe ID <x-required/></label>
							<input type="text" id="id_type" name="id_type" class="form-control @error('id_type') is-invalid @enderror" placeholder="NIP/NITP/NIDN" value="{{ old('id_type', $coordinator->id_type) }}" required>
							@error('id_type')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-9">
						<div class="form-group">
							<label class="form-control-label" for="id_number">Nomor Identifikasi <x-required/></label>
							<input type="text" id="id_number" name="id_number" class="form-control @error('id_number') is-invalid @enderror" placeholder="xxxxxxxxxxxxxx" value="{{ old('id_number', $coordinator->id_number) }}" required>
							@error('id_number')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-12">
						<p class="small" id="preview">Pratinjau: <span class="font-weight-bold">{{ old('id_type', $coordinator->id_type) }} {{ old('id_number', $coordinator->id_number) }}</span></p>
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	<script>
		$('#id_type, #id_number').keyup(function (e){
			$('#preview span').text(
				$('#id_type').val()+" "+$('#id_number').val()
			);
		});
	</script>
@endpush
