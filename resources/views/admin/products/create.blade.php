@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-white">Dodaj Nowy Produkt</h1>
    </div>

    <div class="bg-white/5 rounded-xl p-6 backdrop-blur-sm border border-white/10">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.products.form')
        </form>
    </div>
</div>
@endsection
