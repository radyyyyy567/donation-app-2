@extends('layouts.app')

@section('title', 'Kampanye Donasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Kampanye Donasi</h1>
        <p class="text-gray-600">Mari berbagi kebaikan untuk mereka yang membutuhkan</p>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('donations.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari kampanye..." 
                    value="{{ request('search') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <div>
                <select 
                    name="status" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditutup" {{ request('status') == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua</option>
                </select>
            </div>
            <button 
                type="submit" 
                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
            >
                Cari
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Campaigns Grid -->
    @if($campaigns->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($campaigns as $campaign)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center">
                        <span class="text-white text-6xl">💙</span>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full
                                {{ $campaign->status == 'aktif' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $campaign->status == 'selesai' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $campaign->status == 'ditutup' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-2">
                            {{ $campaign->judul }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ $campaign->deskripsi }}
                        </p>

                        <!-- Progress Bar -->
                        @php
                            $percentage = $campaign->target_donasi > 0 ? ($campaign->terkumpul / $campaign->target_donasi) * 100 : 0;
                            $percentage = min($percentage, 100);
                        @endphp
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Terkumpul</span>
                                <span class="font-semibold text-gray-900">{{ number_format($percentage, 1) }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-xs text-gray-500">Terkumpul</p>
                                <p class="text-lg font-bold text-blue-600">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Target</p>
                                <p class="text-sm font-semibold text-gray-700">Rp {{ number_format($campaign->target_donasi, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('donations.show', $campaign->id) }}" 
                               class="flex-1 text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                Detail
                            </a>
                            @if($campaign->status == 'aktif')
                                <a href="{{ route('donations.create', $campaign->id) }}" 
                                   class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Donasi
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $campaigns->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="text-6xl mb-4">😔</div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tidak ada kampanye ditemukan</h3>
            <p class="text-gray-600">Coba ubah filter atau kata kunci pencarian Anda</p>
        </div>
    @endif
</div>
@endsection