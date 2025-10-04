@extends('layouts.app')

@section('title', 'Pembayaran Donasi')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-purple-50 py-12 px-4">
    <div class="container mx-auto max-w-4xl">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <!-- Step 1: Completed -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-semibold text-gray-700 hidden md:block">Pilih Donasi</span>
                    </div>
                    
                    <div class="w-16 md:w-24 h-1 bg-green-500 mx-2"></div>
                    
                    <!-- Step 2: Active -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-semibold text-blue-600 hidden md:block">Pembayaran</span>
                    </div>
                    
                    <div class="w-16 md:w-24 h-1 bg-gray-300 mx-2"></div>
                    
                    <!-- Step 3: Pending -->
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-semibold text-gray-400 hidden md:block">Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Payment Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Selesaikan Pembayaran</h2>

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Payment Method Info -->
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-4 mb-6">
                        <div class="flex items-start">
                            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-1">Metode Pembayaran: {{ ucfirst($donation->metode_pembayaran) }}</h3>
                                <p class="text-sm text-blue-800">
                                    Silakan selesaikan pembayaran sesuai dengan metode yang Anda pilih
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    @if($donation->metode_pembayaran == 'transfer')
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-900 mb-4">Instruksi Transfer Bank</h3>
                            
                            <div class="space-y-4">
                                <!-- Bank 1 -->
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                                                BCA
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Bank BCA</p>
                                                <p class="text-sm text-gray-600">a.n. DonasiKita Foundation</p>
                                            </div>
                                        </div>
                                        <button onclick="copyToClipboard('1234567890')" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="bg-gray-50 rounded px-3 py-2 font-mono text-lg">
                                        1234567890
                                    </div>
                                </div>

                                <!-- Bank 2 -->
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                                                BNI
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Bank BNI</p>
                                                <p class="text-sm text-gray-600">a.n. DonasiKita Foundation</p>
                                            </div>
                                        </div>
                                        <button onclick="copyToClipboard('0987654321')" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="bg-gray-50 rounded px-3 py-2 font-mono text-lg">
                                        0987654321
                                    </div>
                                </div>

                                <!-- Bank 3 -->
                                <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-green-600 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                                                BRI
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">Bank BRI</p>
                                                <p class="text-sm text-gray-600">a.n. DonasiKita Foundation</p>
                                            </div>
                                        </div>
                                        <button onclick="copyToClipboard('1122334455')" class="text-blue-600 hover:text-blue-700">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="bg-gray-50 rounded px-3 py-2 font-mono text-lg">
                                        1122334455
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($donation->metode_pembayaran == 'e-wallet')
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-900 mb-4">Pilih E-Wallet</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <button class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition text-center">
                                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-white font-bold text-xl">GP</span>
                                    </div>
                                    <p class="font-semibold">GoPay</p>
                                </button>
                                
                                <button class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition text-center">
                                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-white font-bold text-xl">OVO</span>
                                    </div>
                                    <p class="font-semibold">OVO</p>
                                </button>
                                
                                <button class="border-2 border-gray-200 rounded-lg p-4 hover:border-blue-500 transition text-center">
                                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-2">
                                        <span class="text-white font-bold text-xl">DANA</span>
                                    </div>
                                    <p class="font-semibold">Dana</p>
                                </button>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mt-4">
                                <p class="text-sm text-gray-700">
                                    📱 Scan QR code atau gunakan nomor virtual account yang akan muncul setelah memilih e-wallet
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <h3 class="font-bold text-gray-900 mb-4">Pembayaran Kartu Kredit</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Kartu</label>
                                    <input type="text" placeholder="1234 5678 9012 3456" maxlength="19" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">Expired Date</label>
                                        <input type="text" placeholder="MM/YY" maxlength="5"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">CVV</label>
                                        <input type="text" placeholder="123" maxlength="3"
                                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemegang Kartu</label>
                                    <input type="text" placeholder="JOHN DOE"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- How to Pay Steps -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="font-bold text-gray-900 mb-3">Cara Pembayaran</h3>
                        <ol class="space-y-2 text-sm text-gray-700">
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">1</span>
                                <span>Transfer sesuai nominal yang tertera</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">2</span>
                                <span>Simpan bukti transfer Anda</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">3</span>
                                <span>Klik tombol "Konfirmasi Pembayaran" di bawah</span>
                            </li>
                            <li class="flex items-start">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">4</span>
                                <span>Donasi Anda akan diproses dalam 1x24 jam</span>
                            </li>
                        </ol>
                    </div>

                    <!-- Confirm Payment -->
                    <form method="POST" action="{{ route('donations.process-payment', $donation->id) }}">
                        @csrf
                        
                        <div class="flex items-start mb-6">
                            <input type="checkbox" id="confirm" required class="w-4 h-4 text-blue-600 mt-1 mr-2">
                            <label for="confirm" class="text-sm text-gray-700">
                                Saya telah melakukan pembayaran sesuai nominal yang tertera dan memahami bahwa proses verifikasi membutuhkan waktu maksimal 1x24 jam
                            </label>
                        </div>

                        <div class="flex gap-4">
                            <a href="{{ route('donations.show', $donation->campaign_id) }}" 
                               class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>
                            <button type="submit"
                                    class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                                Konfirmasi Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl p-6 sticky top-6">
                    <h3 class="font-bold text-gray-900 mb-4">Ringkasan Donasi</h3>
                    
                    <div class="mb-4">
                        <div class="h-24 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                            <span class="text-white text-4xl">💙</span>
                        </div>
                    </div>

                    <h4 class="font-semibold text-gray-900 mb-2">{{ $donation->campaign->judul }}</h4>
                    
                    <div class="border-t border-b border-gray-200 py-4 my-4 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Nominal Donasi</span>
                            <span class="font-semibold">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Admin</span>
                            <span class="font-semibold text-green-600">Gratis</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-gray-900">Total Pembayaran</span>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</span>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-yellow-800 mb-1">Selesaikan dalam 24 jam</p>
                                <p class="text-xs text-yellow-700">Donasi akan dibatalkan otomatis jika tidak diselesaikan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
        toast.textContent = '✓ Nomor rekening berhasil disalin!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    });
}
</script>
@endsection