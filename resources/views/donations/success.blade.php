@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-blue-50 py-12 px-4">
    <div class="container mx-auto max-w-2xl">
        <!-- Success Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Success Header -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white text-center py-12 px-6">
                <!-- Animated Success Icon -->
                <div class="mb-6 animate-bounce">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto shadow-lg">
                        <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-4xl font-bold mb-3">Pembayaran Berhasil!</h1>
                <p class="text-green-100 text-lg">Terima kasih atas kebaikan Anda</p>
            </div>

            <!-- Body Content -->
            <div class="p-8">
                <!-- Thank You Message -->
                <div class="text-center mb-8">
                    <p class="text-gray-700 text-lg leading-relaxed">
                        Donasi Anda sebesar <span class="font-bold text-green-600">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</span> 
                        untuk kampanye <span class="font-bold text-gray-900">"{{ $donation->campaign->judul }}"</span> 
                        telah berhasil diproses.
                    </p>
                </div>

                <!-- Transaction Details -->
                <div class="bg-gray-50 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Detail Transaksi
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Nomor Transaksi</span>
                            <span class="font-mono font-semibold text-gray-900">#DN{{ str_pad($donation->id, 8, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Tanggal & Waktu</span>
                            <span class="font-semibold text-gray-900">{{ $donation->tanggal}} WIB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Metode Pembayaran</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($donation->metode_pembayaran) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Status</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                Sukses
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Campaign Impact -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Dampak Donasi Anda
                    </h3>
                    <p class="text-gray-700 text-sm mb-4">
                        Dengan donasi Anda, kampanye ini semakin dekat mencapai targetnya:
                    </p>
                    
                    @php
                        $percentage = $donation->campaign->target_donasi > 0 
                            ? ($donation->campaign->terkumpul / $donation->campaign->target_donasi) * 100 
                            : 0;
                        $percentage = min($percentage, 100);
                    @endphp
                    
                    <div class="mb-3">
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-gray-600">Progress</span>
                            <span class="font-bold text-blue-600">{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-3 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Terkumpul</span>
                            <p class="font-bold text-blue-600">Rp {{ number_format($donation->campaign->terkumpul, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-gray-600">Target</span>
                            <p class="font-bold text-gray-900">Rp {{ number_format($donation->campaign->target_donasi, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Motivational Message -->
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex items-start">
                        <span class="text-3xl mr-3">💛</span>
                        <div>
                            <h4 class="font-semibold text-yellow-900 mb-1">Berbagi Kebaikan</h4>
                            <p class="text-sm text-yellow-800">
                                "Sedekah tidak akan mengurangi harta. Sebaliknya, Allah akan melipatgandakan pahala bagi yang bersedekah."
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('donations.receipt', $donation->id) }}" 
                       class="block w-full text-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition shadow-lg">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Bukti Donasi
                    </a>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('donations.show', $donation->campaign_id) }}" 
                           class="text-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            Lihat Kampanye
                        </a>
                        <a href="{{ route('donations.my-donations') }}" 
                           class="text-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                            Riwayat Donasi
                        </a>
                    </div>

                    <a href="{{ route('donations.index') }}" 
                       class="block w-full text-center px-6 py-3 bg-white border-2 border-blue-600 text-blue-600 font-semibold rounded-lg hover:bg-blue-50 transition">
                        Donasi Lagi
                    </a>
                </div>

                <!-- Share Section -->
                <div class="mt-8 pt-8 border-t border-gray-200 text-center">
                    <p class="text-gray-600 mb-4">Ajak teman Anda untuk ikut berdonasi</p>
                    <div class="flex justify-center gap-3">
                        <button onclick="shareToFacebook()" class="p-3 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </button>
                        <button onclick="shareToTwitter()" class="p-3 bg-sky-500 text-white rounded-full hover:bg-sky-600 transition shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </button>
                        <button onclick="shareToWhatsApp()" class="p-3 bg-green-500 text-white rounded-full hover:bg-green-600 transition shadow-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </button>
                        <button onclick="copyLink()" class="p-3 bg-gray-600 text-white rounded-full hover:bg-gray-700 transition shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer Badge -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-4">
                <p class="text-sm font-semibold">✨ Anda telah menjadi bagian dari kebaikan ✨</p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-gray-600 text-sm">
                Butuh bantuan? Hubungi kami di 
                <a href="mailto:support@donasikita.id" class="text-blue-600 hover:underline font-semibold">support@donasikita.id</a>
            </p>
        </div>
    </div>
</div>

<script>
const campaignUrl = "{{ route('donations.show', $donation->campaign_id) }}";
const campaignTitle = "{{ $donation->campaign->judul }}";

function shareToFacebook() {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(window.location.origin + campaignUrl)}`;
    window.open(url, '_blank', 'width=600,height=400');
}

function shareToTwitter() {
    const text = `Saya baru saja berdonasi untuk "${campaignTitle}". Mari kita bantu bersama! 💙`;
    const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(window.location.origin + campaignUrl)}`;
    window.open(url, '_blank', 'width=600,height=400');
}

function shareToWhatsApp() {
    const text = `Saya baru saja berdonasi untuk "${campaignTitle}". Mari kita bantu bersama! 💙 ${window.location.origin + campaignUrl}`;
    const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
    window.open(url, '_blank');
}

function copyLink() {
    const link = window.location.origin + campaignUrl;
    navigator.clipboard.writeText(link).then(function() {
        showToast('✓ Link berhasil disalin!', 'success');
    });
}

function showToast(message, type) {
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-blue-500';
    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.remove();
    }, 3000);
}
</script>

<style>
@keyframes slide-up {
    from {
        transform: translateY(100px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}   

.animate-slide-up {
    animation: slide-up 0.3s ease-out;
}
</style>
@endsection