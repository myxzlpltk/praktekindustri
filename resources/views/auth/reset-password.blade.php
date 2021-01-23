@extends('layouts.app')

@section('bodyClass', 'bg-gradient-primary')

@section('title', "Simple Page")

@push('stylesheets')
@endpush

@section('simple')
    <div class="container">
        <p>Hello World</p>
    </div>
@endsection

@push('scripts')
@endpush
