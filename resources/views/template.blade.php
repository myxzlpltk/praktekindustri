@extends('layouts.app')

@section('title', "Welcome")

@push('stylesheets')
@endpush

@section('content')
	<p>Hello World</p>
	<p>{{Auth::user()->student->prodi_id}}</p>
@endsection

@push('scripts')
@endpush
