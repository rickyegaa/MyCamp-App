@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<h4 class="mb-3">Edit Kategori</h4>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('kategori.update', $kategori) }}" method="POST">
        @csrf @method('PUT')
        @include('kategori._form')
    </form>
</div></div>
@endsection
