@extends('layouts.app')
@section('title', 'Tambah Peralatan')

@section('content')
<h4 class="mb-3">Tambah Peralatan</h4>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('peralatan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('peralatan._form')
    </form>
</div></div>
@endsection
