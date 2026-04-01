@extends('layouts.admin')

@section('content')
<div class="container-fluid p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-church mr-2"></i>Penerbitan Akta Pernikahan</h1>
        <p class="text-gray-600 mt-1">Penerbitan dokumen Akta Pernikahan</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="text-center py-12">
            <div class="text-6xl mb-4"><i class="fas fa-hard-hat"></i></div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Fitur Sedang Dikembangkan</h2>
            <p class="text-gray-600 mb-6">Halaman penerbitan pernikahan sedang dalam pengembangan.</p>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection