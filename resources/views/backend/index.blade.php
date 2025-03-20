@extends('layouts.backend')
@section('title', 'Dashboard Overzicht')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('backend.index') }}">Home</a></li>
    <li class="breadcrumb-item active">Backend</li>
@endsection
@section('cards')
    @include('layouts.partials.cards')
@endsection
@section('content')
    @yield('cards')
@endsection

