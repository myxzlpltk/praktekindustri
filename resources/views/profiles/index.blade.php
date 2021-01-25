@extends('layouts.app')

@section('title', "Profil Saya")

@push('stylesheets')
@endpush

@section('content')
	@if($user->isStudent)
		<div class="card shadow mb-4">
			<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
				<h6 class="m-0 font-weight-bold text-primary">Informasi Mahasiswa</h6>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3">
						<div class="thumbnail rounded-circle mx-auto shadow mb-4">
							<img src="https://api.um.ac.id/akademik/operasional/GetFoto.ptikUM?nim={{ $user->student->nim }}&angkatan={{ $user->student->angkatan }}" alt="Photo">
						</div>
					</div>
					<div class="col-md-9">
						<table class="table table-sm">
							<tr>
								<th>Nomor Induk Mahasiswa</th>
								<td>{{ $user->student->nim }}</td>
							</tr>
							<tr>
								<th>Nama Lengkap</th>
								<td>{{ $user->student->name }}</td>
							</tr>
							<tr>
								<th>Program Studi</th>
								<td>{{ optional($user->student->prodi)->name }}</td>
							</tr>
							<tr>
								<th>Tahun Angkatan</th>
								<td>{{ $user->student->angkatan }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	@endif

    <div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Pengguna</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('user-profile-information.update') }}" method="post" enctype="multipart/form-data">
				@method('put')
				@csrf
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label class="form-control-label" for="input-name">Nama Lengkap <x-required/></label>
							<input type="text" id="input-name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Lengkap" value="{{ old('name', $user->name) }}" required>
							@error('name')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label class="form-control-label" for="input-email">Email address <x-required/></label>
							<div class="input-group input-group-merge">
								<input type="email" id="input-email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Alamat Email" value="{{ old('email', $user->email) }}" required>
								<div class="input-group-append bg-white">
									<div class="input-group-text">
										@if($user->hasVerifiedEmail())
											<i class="fas fa-check-circle fa-fw text-primary" data-toggle="tooltip" title="Terverifikasi"></i>
										@else
											<i class="fas fa-times-circle fa-fw text-danger" data-toggle="tooltip" title="Tidak Terverifikasi"></i>
										@endif
									</div>
								</div>
							</div>
							@error('email')
							<div class="invalid-feedback d-block">{{ $message }}</div>
							@enderror
						</div>
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
			</form>
		</div>
	</div>

	@if($user->isCoordinator)
	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Informasi Nomor Identifikasi</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('profile.coordinator-update') }}" method="post" enctype="multipart/form-data">
				@method('PATCH')
				@csrf

				<div class="row">
					<div class="col-3">
						<div class="form-group">
							<label class="form-control-label" for="id_type">Tipe ID <x-required/></label>
							<input type="text" id="id_type" name="id_type" class="form-control @error('id_type') is-invalid @enderror" placeholder="NIP/NITP/NIDN" value="{{ old('id_type', $user->coordinator->id_type) }}" required>
							@error('id_type')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-9">
						<div class="form-group">
							<label class="form-control-label" for="id_number">Nomor Identifikasi <x-required/></label>
							<input type="text" id="id_number" name="id_number" class="form-control @error('id_number') is-invalid @enderror" placeholder="xxxxxxxxxxxxxx" value="{{ old('id_number', $user->coordinator->id_number) }}" required>
							@error('id_number')
							<div class="invalid-feedback">{{ $message }}</div>
							@enderror
						</div>
					</div>
					<div class="col-12">
						<p class="small" id="preview">Pratinjau: <span class="font-weight-bold">{{ old('id_type', $user->coordinator->id_type) }} {{ old('id_number', $user->coordinator->id_number) }}</span></p>
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Simpan</button>
			</form>
		</div>
	</div>
	@endif

	<div class="card shadow mb-4">
		<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
			<h6 class="m-0 font-weight-bold text-primary">Ganti Kata Sandi</h6>
		</div>
		<div class="card-body">
			<form action="{{ route('user-password.update') }}" method="post">
				@method('put')
				@csrf

				@if($user->password)
					<div class="form-group">
						<label class="form-control-label" for="input-current-password">Kata Sandi Saat Ini <x-required/></label>
						<input type="password" id="input-current-password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" placeholder="Masukkan kata sandi saat ini">
						@error('current_password')
						<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>
				@endif
				<div class="form-group">
					<label class="form-control-label" for="input-password">Kata Sandi Baru <x-required/></label>
					<input type="password" id="input-password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan kata sandi baru">
					@error('password')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<div class="form-group">
					<label class="form-control-label" for="input-password-confirmation">Konfirmasi Kata Sandi Baru <x-required/></label>
					<input type="password" id="input-password-confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Ketik ulang kata sandi baru">
					@error('password_confirmation')
					<div class="invalid-feedback">{{ $message }}</div>
					@enderror
				</div>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save fa-fw"></i> Perbarui</button>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	@if($user->isCoordinator)
		<script>
			$('#id_type, #id_number').keyup(function (e){
				$('#preview span').text(
					$('#id_type').val()+" "+$('#id_number').val()
				);
			});
		</script>
	@endif
@endpush
