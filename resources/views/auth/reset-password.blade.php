@extends('layouts.app')

@section('bodyClass', 'bg-gradient-info')

@section('title', "Reset kata sandi")

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
										<h1 class="h4 text-gray-900 mb-2">Reset Kata Sandi</h1>
										<p class="mb-4">Pilih kata sandi yang sulit ditebak dan mudah diingat!</p>
									</div>
									<form action="{{ route('password.update') }}" method="POST" role="form" class="user">
										@csrf
										<input type="hidden" name="token" value="{{ $request->route('token') }}">
										<div class="form-group">
											<input class="form-control form-control-user @error('email') is-invalid @enderror" placeholder="Email" type="email" name="email" value="{{ old('email', $request->email) }}" required>
											@error('email')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										<div class="form-group">
											<input class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Kata Sandi Baru" type="password" name="password" autocomplete="new-password" autofocus required>
											@error('password')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										<div class="form-group">
											<input class="form-control form-control-user @error('password_confirmation') is-invalid @enderror" placeholder="Ketik Ulang Kata Sandi Baru" type="password" name="password_confirmation" autocomplete="new-password"    required>
											@error('password_confirmation')
											<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>
										<div class="text-center">
											<button type="submit" class="btn btn-primary btn-user btn-block">Reset Kata Sandi</button>
										</div>
									</form>
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
