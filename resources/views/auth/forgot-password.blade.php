@extends('layouts.app')

@section('bodyClass', 'bg-gradient-info')

@section('title', "Lupa Kata Sandi")

@push('stylesheets')
@endpush

@section('simple')
    <div class="container">
		<div class="row justify-content-center">

			<div class="col-xl-10 col-lg-12 col-md-9">

				<div class="card o-hidden border-0 shadow-lg my-5">
					<div class="card-body p-0">
						<!-- Nested Row within Card Body -->
						<div class="row">
							<div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
							<div class="col-lg-6">
								<div class="p-5">

									@include('layouts.flash')

									<div class="text-center">
										<h1 class="h4 text-gray-900 mb-2">Lupa Kata Sandi?</h1>
										<p class="mb-4">Kami mengerti, terkadang hal tersebut sering terjadi. Cukup masukkan email dibawah ini dan kami akan mengirimkan tautan untuk mengganti kata sandi kamu!</p>
									</div>
									<form action="{{ route('password.email') }}" method="POST" class="user">
										@csrf
										<div class="form-group">
											<input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" placeholder="Masukkan alamat email" required>
											@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										<button type="submit" class="btn btn-primary btn-user btn-block">Reset Kata Sandi</button>
									</form>
									<hr>
									<div class="text-center">
										<a class="small" href="{{ route('register') }}">Buat akun!</a>
									</div>
									<div class="text-center">
										<a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
    </div>
@endsection

@push('scripts')
@endpush
