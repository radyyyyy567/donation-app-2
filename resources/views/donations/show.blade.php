@extends('layouts.app')

@section('title', $campaign->judul)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('donations.index') }}" class="text-blue-600 hover:underline">Kampanye</a>
        <span class="mx-2 text-gray-500">/</span>
        <span class="text-gray-700">{{ Str::limit($campaign->judul, 50) }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Campaign Image -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg h-96 flex items-center justify-center mb-6">
                <span class="text-white text-9xl">💙</span>
            </div>

            <!-- Campaign Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                        {{ $campaign->status == 'aktif' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $campaign->status == 'selesai' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $campaign->status == 'ditutup' ? 'bg-gray-100 text-gray-800' : '' }}
                    ">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $campaign->judul }}</h1>

                @if($campaign->campaign_owner && $campaign->campaign_owner->organization)
                    <div class="flex items-center text-gray-600 mb-6">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span>{{ $campaign->campaign_owner->organization->nama }}</span>
                    </div>
                @endif

                <div class="prose max-w-none">
                    <h2 class="text-xl font-semibold mb-3">Deskripsi Kampanye</h2>
                    <p class="text-gray-700 whitespace-pre-line">{{ $campaign->deskripsi }}</p>
                </div>
            </div>

            <!-- Recent Donations -->
            @if($recentDonations->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">Donasi Terbaru</h2>
                    <div class="space-y-3">
                        @foreach($recentDonations as $donation)
                            <div class="flex items-center justify-between border-b pb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                        <span class="text-blue-600 font-semibold">
                                            {{ strtoupper(substr($donation->user->nama, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $donation->user->nama }}</p>
                                        <p class="text-xs text-gray-500">{{ $donation->tanggal}}</p>
                                    </div>
                                </div>
                                <p class="font-bold text-blue-600">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Progress Donasi</h2>
                
                <!-- Progress Bar -->
                <div class="mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Terkumpul</span>
                        <span class="font-semibold text-gray-900">{{ number_format($percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all" style="width: {{ min($percentage, 100) }}%"></div>
                    </div>
                </div>

                <!-- Amount Info -->
                <div class="space-y-4 mb-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Dana Terkumpul</p>
                        <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Target Donasi</p>
                        <p class="text-xl font-semibold text-gray-900">Rp {{ number_format($campaign->target_donasi, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Sisa Dana</p>
                        <p class="text-lg font-semibold text-gray-700">
                            Rp {{ number_format(max($campaign->target_donasi - $campaign->terkumpul, 0), 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Dates -->
                <div class="border-t pt-4 mb-6 space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Mulai</span>
                        <span class="font-semibold">{{ $campaign->tanggal_mulai }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Berakhir</span>
                        <span class="font-semibold">{{ $campaign->tanggal_selesai }}</span>
                    </div>
                    @if($campaign->status == 'aktif')
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Sisa Waktu</span>
                            <span class="font-semibold text-orange-600">
                                {{ $campaign->tanggal_selesai }}
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Donate Button -->
                @if($campaign->status == 'aktif')
                    <a href="{{ route('donations.create', $campaign->id) }}" 
                       class="block w-full text-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                        Donasi Sekarang
                    </a>
                @else
                    <button disabled 
                            class="block w-full text-center px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                        Kampanye {{ ucfirst($campaign->status) }}
                    </button>
                @endif

                <!-- Share -->
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600 mb-2">Bagikan kampanye ini</p>
                    <div class="flex justify-center gap-2">
                        <button class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </button>
                        <button class="p-2 bg-sky-100 text-sky-600 rounded-lg hover:bg-sky-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </button>
                        <button class="p-2 bg-green-100 text-green-600 rounded-lg hover:bg-green-200 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection