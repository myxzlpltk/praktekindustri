@extends('layouts.app')

@section('bodyClass', 'bg-gradient-primary')

@section('title', "Simple Page")

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
										<h1 class="h4 text-gray-900 mb-2">Verifikasi Email Kamu</h1>
										<p class="mb-4">Tautan verifikasi email baru telah dikirim ke email Anda! Silahkan cek kotak masuk atau kotak spam.</p>
										<form action="{{ route('verification.send') }}" method="POST" class="user">
											@csrf
											<p>Masih belum menerima email hingga saat ini?</p>
											<button type="submit" class="btn btn-primary btn-user btn-block">Kirim Ulang</button>
										</form>
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
