{{-- resources/views/errors/404.blade.php --}}

@extends('layouts.app')

@section('title', '404')

@section('content')

<div class="container text-center py-5">

    <h1 class="display-1 fw-bold text-warning">
        404
    </h1>

    <h3>Trang Không Tồn Tại</h3>

    <a href="{{ route('home') }}"
       class="btn btn-primary mt-3">

        Quay Về Trang Chủ

    </a>

</div>

@endsection