<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Donasi #{{ $donation->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Print Button -->
        <div class="mb-4 no-print">
            <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak / Simpan PDF
            </button>
            <a href="{{ route('donations.my-donations') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition ml-2">
                Kembali
            </a>
        </div>

        <!-- Receipt Card -->
        <div class="bg-white rounded-lg shadow-lg max-w-2xl mx-auto overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-8">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-white rounded-lg flex items-center justify-center">
                            <span class="text-3xl">💙</span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">DonasiKita</h1>
                            <p class="text-blue-100 text-sm">Platform Donasi Terpercaya</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold inline-block">
                            ✓ BERHASIL
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-8">
                <!-- Title -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Bukti Donasi</h2>
                    <p class="text-gray-600">Terima kasih atas kontribusi Anda</p>
                </div>

                <!-- Donation Details -->
                <div class="border-t border-b border-gray-200 py-6 mb-6">
                    <div class="grid grid-cols-2 gap-6 mb-4">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Nomor Transaksi</p>
                            <p class="font-semibold text-gray-900">#DN{{ str_pad($donation->id, 8, '0', STR_PAD_LEFT) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 mb-1">Tanggal</p>
                            <p class="font-semibold text-gray-900">{{ $donation->tanggal->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="bg-blue-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-600 mb-1">Jumlah Donasi</p>
                        <p class="text-4xl font-bold text-blue-600">Rp {{ number_format($donation->jumlah, 0, ',', '.') }}</p>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nama Donatur</span>
                            <span class="font-semibold text-gray-900">{{ $donation->user->nama }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class="font-semibold text-gray-900">{{ $donation->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Metode Pembayaran</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($donation->metode_pembayaran) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="font-semibold text-green-600">{{ ucfirst($donation->status) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Campaign Details -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-3">Detail Kampanye</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $donation->campaign->judul }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($donation->campaign->deskripsi, 150) }}</p>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Target:</span>
                                <span class="font-semibold text-gray-900 ml-2">Rp {{ number_format($donation->campaign->target_donasi, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Terkumpul:</span>
                                <span class="font-semibold text-blue-600 ml-2">Rp {{ number_format($donation->campaign->terkumpul, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thank You Message -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 text-center">
                    <div class="text-4xl mb-3">🙏</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Terima Kasih!</h3>
                    <p class="text-gray-600">
                        Donasi Anda sangat berarti dan akan disalurkan sesuai dengan tujuan kampanye.
                        Semoga kebaikan Anda dibalas dengan berlipat ganda.
                    </p>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-200">
                <div class="grid grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="font-semibold text-gray-900 mb-2">DonasiKita</p>
                        <p class="text-gray-600 text-xs">
                            Platform Donasi Online<br>
                            Email: info@donasikita.id<br>
                            Phone: +62 812-3456-7890
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-gray-900 mb-2">Dokumen Resmi</p>
                        <p class="text-gray-600 text-xs">
                            Bukti donasi ini sah dan dapat<br>
                            digunakan untuk keperluan<br>
                            administrasi dan pelaporan
                        </p>
                    </div>
                </div>
                
                <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                    <p class="text-xs text-gray-500">
                        Dokumen ini dicetak pada {{ now()->format('d M Y H:i:s') }} WIB
                    </p>
                </div>
            </div>
        </div>

        <!-- Verification Info -->
        <div class="max-w-2xl mx-auto mt-6 text-center text-sm text-gray-500 no-print">
            <p>
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Bukti donasi ini terverifikasi dan tersimpan dalam sistem kami
            </p>
        </div>
    </div>
</body>
</html>