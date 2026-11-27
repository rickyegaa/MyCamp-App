@extends('layouts.app')
@section('title', 'Edit Peralatan')

@section('content')
<h4 class="mb-3">Edit Peralatan</h4>
<div class="card shadow-sm"><div class="card-body">
    <form action="{{ route('peralatan.update', $peralatan) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('peralatan._form')
    </form>
</div></div>
@endsection
