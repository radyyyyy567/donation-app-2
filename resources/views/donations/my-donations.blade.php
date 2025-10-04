@extends('layouts.app')

@section('title', 'Riwayat Donasi Saya')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-2">Riwayat Donasi Saya</h1>
        <p class="text-gray-600">Terima kasih atas kontribusi Anda dalam berbagi kebaikan</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Donations -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Donasi</p>
                    <p class="text-3xl font-bold">{{ $donations->total() }}</p>
                </div>
                <div class="bg-blue-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-blue-100 text-xs">Semua transaksi</p>
        </div>

        <!-- Successful Donations -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-green-100 text-sm font-medium">Berhasil</p>
                    <p class="text-3xl font-bold">{{ $successCount }}</p>
                </div>
                <div class="bg-green-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-green-100 text-xs">Donasi sukses</p>
        </div>

        <!-- Pending Donations -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-yellow-100 text-sm font-medium">Pending</p>
                    <p class="text-3xl font-bold">{{ $pendingCount }}</p>
                </div>
                <div class="bg-yellow-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-yellow-100 text-xs">Menunggu pembayaran</p>
        </div>

        <!-- Total Amount -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-2">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Total Nilai</p>
                    <p class="text-2xl font-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
                <div class="bg-purple-400 bg-opacity-30 rounded-full p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-purple-100 text-xs">Donasi berhasil</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <a href="{{ route('donations.my-donations') }}" 
                   class="px-6 py-4 text-sm font-medium {{ !request('status') ? 'border-b-2 border-blue-600 text-blue-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Semua ({{ $donations->total() }})
                </a>
                <a href="{{ route('donations.my-donations', ['status' => 'sukses']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') == 'sukses' ? 'border-b-2 border-green-600 text-green-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Berhasil ({{ $successCount }})
                </a>
                <a href="{{ route('donations.my-donations', ['status' => 'pending']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') == 'pending' ? 'border-b-2 border-yellow-600 text-yellow-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('donations.my-donations', ['status' => 'gagal']) }}" 
                   class="px-6 py-4 text-sm font-medium {{ request('status') == 'gagal' ? 'border-b-2 border-red-600 text-red-600' : 'text-gray-600 hover:text-gray-900' }}">
                    Gagal ({{ $failedCount }})
                </a>
            </nav>
        </div>
    </div>

    <!-- Donations List -->
    @if($donations->count() > 0)
        <div class="space-y-4 mb-8">
            @foreach($donations as $donation)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <!-- Left Section -->
                            <div class="flex items-start space-x-4 flex-1">
                                <!-- Campaign Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white text-2xl">💙</span>
                                    </div>
                                </div>

                                <!-- Campaign Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-bold text-gray-900 truncate">
                                            {{ $donation->campaign->judul }}
                                        </h3>
                                        <span class="flex-shrink-0 px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $donation->status == 'sukses' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $donation->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $donation->status == 'gagal' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-2">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $donation->tanggal}}
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            {{ ucfirst($donation->metode_pembayaran) }}
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-500">
                                        {{ $donation->tanggal }}
                                    </p>
                                </div>
                            </div>

                            <!-- Right Section -->
                            <div class="flex flex-col md:items-end justify-between gap-3">
                                <!-- Amount -->
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 mb-1">Jumlah Donasi</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        Rp {{ number_format($donation->jumlah, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('donations.show', $donation->campaign_id) }}" 
                                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition text-sm font-medium">
                                        Lihat Kampanye
                                    </a>
                                    
                                    @if($donation->status == 'pending')
                                        <a href="{{ route('donations.payment', $donation->id) }}" 
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                            Bayar Sekarang
                                        </a>
                                    @endif
                                    
                                    @if($donation->status == 'sukses')
                                        <button onclick="downloadReceipt({{ $donation->id }})"
                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Bukti
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info (Collapsible) -->
                    @if($donation->status == 'gagal')
                        <div class="bg-red-50 border-t border-red-100 px-6 py-3">
                            <p class="text-sm text-red-700">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pembayaran gagal diproses. Silakan coba lagi atau hubungi customer service.
                            </p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $donations->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">
                @if(request('status'))
                    Tidak ada donasi dengan status "{{ request('status') }}"
                @else
                    Belum ada riwayat donasi
                @endif
            </h3>
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

<script>
function downloadReceipt(donationId) {
    // Simulate download receipt
    alert('Fitur download bukti donasi akan segera tersedia!\nDonation ID: ' + donationId);
    // In production, you would redirect to a receipt generation endpoint:
    // window.location.href = '/donations/' + donationId + '/receipt';
}
</script>
@endsection