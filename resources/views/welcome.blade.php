@extends('layouts.app')

@section('bodyClass', 'bg-gradient-light')

@section('title', "Selamat Datang")

@push('stylesheets')
@endpush

@section('simple')
	<div class="container text-dark py-5">
		<div class="row">
			<div class="col-md-6 col-lg-7 order-6 order-md-0">
				<h1 class="display-4 font-weight-bold text-center text-md-left animate__animated animate__backInLeft">Selamat Datang di SIOTANG !</h1>
				<p class="lead mt-3">SiOTANG - Sistem Informasi Pelayanan Tanda Tangan!<p>
				<p class="lead">Sistem informasi yang memfasilitasi mahasiswa dalam mengajukan tanda tangan digital kepada dosen atau pimpinan di jurusan Teknik Elektro Universitas Negeri Malang.</p>


				<a href="{{ route('login') }}" class="btn btn-primary"><i class="fa fa-sign-in-alt fa-fw"></i> Masuk</a>
				<a href="{{ route('register') }}" class="btn btn-light"><i class="fa fa-user-plus fa-fw"></i> Daftar</a>

				<div class="my-5">
					<p class="text-center">Copyright &copy; SIOTANG 2021</p>
				</div>
			</div>
			<div class="col-md-6 col-lg-5">
				<img src="{{ asset('img/undraw_career_development.svg') }}" class="img-fluid mt-md-5 mb-4" alt="Ilustrasi">
			</div>
		</div>
	</div>
@endsection

@push('scripts')
@endpush
