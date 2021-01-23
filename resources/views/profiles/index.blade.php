@extends('layouts.app')

@section('title', "Profil Saya")

@push('stylesheets')
@endpush

@section('content')
	@if($user->isStudent && !$user->student->valid)
		<div class="alert alert-warning alert-dismissible fade show" role="alert">
			<p class="mb-0">
				<span class="alert-icon"><i class="fa fa-bullhorn fa-fw"></i></span>
				<strong>Informasi Singkat....</strong>
			</p>
			<span class="alert-text">Status pendaftaran akun kamu masih diperiksa untuk diverifikasi. Sehingga saat ini kamu hanya bisa mengakses halaman ini. Silahkan cek lagi nanti.</span>
		</div>
	@endif

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
@endpush
