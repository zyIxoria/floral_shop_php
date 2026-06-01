{{-- resources/views/errors/500.blade.php --}}

@extends('layouts.app')

@section('title', '500')

@section('content')

<div class="container text-center py-5">

    <h1 class="display-1 fw-bold text-danger">
        500
    </h1>

    <h3>Lỗi Hệ Thống</h3>

    <a href="{{ route('home') }}"
       class="btn btn-primary mt-3">

        Quay Về Trang Chủ

    </a>

</div>

@endsection