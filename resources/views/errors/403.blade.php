{{-- resources/views/errors/403.blade.php --}}

@extends('layouts.app')

@section('title', '403')

@section('content')

<div class="container text-center py-5">

    <h1 class="display-1 fw-bold text-danger">
        403
    </h1>

    <h3>Không Có Quyền Truy Cập</h3>

    <a href="{{ route('home') }}"
       class="btn btn-primary mt-3">

        Quay Về Trang Chủ

    </a>

</div>

@endsection
