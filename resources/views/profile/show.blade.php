@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Profil Saya</h1>
        <p class="text-gray-600">Kelola informasi pribadi dan aktivitas donasi Anda</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <!-- Profile Header -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-8 text-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-4xl font-bold text-blue-600">
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-1">{{ $user->nama }}</h2>
                    <p class="text-blue-100">{{ $user->email }}</p>
                </div>

                <!-- Profile Info -->
                <div class="p-6 space-y-4">
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Nama Lengkap</label>
                        <p class="text-gray-900 font-medium flex items-center">
                          <svg class="w-4 h-4 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="currentColor" width="32" height="32"  viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
                            {{ $user->name }}   
                        </p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Nomor Telepon</label>
                        <p class="text-gray-900 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            {{ $user->no_telp }}
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-500 mb-1 block">Alamat</label>
                        <p class="text-gray-900 font-medium flex items-start">
                            <svg class="w-4 h-4 mr-2 text-gray-400 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $user->alamat }}
                        </p>
                    </div>

                    <div class="pt-4 border-t">
                        <p class="text-xs text-gray-500">Bergabung sejak</p>
                        <p class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <!-- Edit Button -->
                <div class="p-6 border-t bg-gray-50">
                    <a href="{{ route('profile.edit') }}" 
                       class="block w-full text-center px-4 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column - Statistics & Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Donations -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-blue-100 text-sm">Total Donasi</p>
                            <p class="text-3xl font-bold">{{ $totalDonations }}</p>
                        </div>
                        <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-blue-100 text-xs">Semua transaksi</p>
                </div>

                <!-- Success Donations -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div>
                            <p class="text-green-100 text-sm">Berhasil</p>
                            <p class="text-3xl font-bold">{{ $successDonations }}</p>
                        </div>
                        <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-green-100 text-xs">Donasi sukses</p>
                </div>

                <!-- Total Amount -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-2">
                        <div class="min-w-0">
                            <p class="text-purple-100 text-sm">Total Nilai</p>
                            <p class="text-2xl font-bold truncate">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-purple-400 bg-opacity-30 rounded-full p-3 flex-shrink-0">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-purple-100 text-xs">Donasi berhasil</p>
                </div>
            </div>

            <!-- Recent Donations -->
            @if($recentDonations->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Donasi Terbaru
                        </h3>
                        <a href="{{ route('donations.my-donations') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                            Lihat Semua →
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach($recentDonations as $donation)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4 flex-1 min-w-0">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xl">💙</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 truncate">{{ $donation->campaign->judul }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-xs text-gray-500">{{ $donation->tanggal }}</span>
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                                {{ $donation->status == 'sukses' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $donation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $donation->status == 'gagal' ? 'bg-red-100 text-red-800' : '' }}
                                            ">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right ml-4 flex-shrink-0">
                                    <p class="font-bold text-blue-600">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Campaigns Supported -->
            @if($campaigns->count() > 0)
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        Kampanye yang Didukung ({{ $campaigns->count() }})
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($campaigns->take(4) as $campaign)
                            <a href="{{ route('donations.show', $campaign->id) }}" 
                               class="block border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 hover:shadow-md transition">
                                <div class="flex items-start space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-white text-xl">💙</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-semibold text-gray-900 text-sm truncate">{{ $campaign->judul }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ ucfirst($campaign->status) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if($campaigns->count() > 4)
                        <div class="mt-4 text-center">
                            <a href="{{ route('donations.my-donations') }}" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">
                                Lihat {{ $campaigns->count() - 4 }} kampanye lainnya →
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Donasi</h3>
                    <p class="text-gray-600 mb-6">Mulai berbagi kebaikan dengan berdonasi sekarang</p>
                    <a href="{{ route('donations.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Cari Kampanye
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection