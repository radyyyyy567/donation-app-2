@extends('layouts.app')

@section('title', 'Buat Donasi')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('donations.index') }}" class="text-blue-600 hover:underline">Kampanye</a>
        <span class="mx-2 text-gray-500">/</span>
        <a href="{{ route('donations.show', $campaign->id) }}" class="text-blue-600 hover:underline">{{ Str::limit($campaign->judul, 30) }}</a>
        <span class="mx-2 text-gray-500">/</span>
        <span class="text-gray-700">Donasi</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-6">Buat Donasi</h1>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('donations.store') }}">
                    @csrf
                    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">

                    <!-- Nominal Donasi -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">
                            Nominal Donasi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 font-semibold">Rp</span>
                            <input 
                                type="number" 
                                name="jumlah" 
                                value="{{ old('jumlah') }}"
                                min="10000"
                                step="1000"
                                placeholder="50000"
                                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jumlah') border-red-500 @enderror"
                                required
                            >
                        </div>
                        <p class="text-sm text-gray-500 mt-2">Minimal donasi Rp 10.000</p>
                        @error('jumlah')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quick Amount Buttons -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-2">Atau pilih nominal cepat</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <button type="button" onclick="setAmount(50000)" class="quick-amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">
                                Rp 50.000
                            </button>
                            <button type="button" onclick="setAmount(100000)" class="quick-amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">
                                Rp 100.000
                            </button>
                            <button type="button" onclick="setAmount(200000)" class="quick-amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">
                                Rp 200.000
                            </button>
                            <button type="button" onclick="setAmount(500000)" class="quick-amount-btn px-4 py-3 border-2 border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition font-semibold">
                                Rp 500.000
                            </button>
                        </div>
                    </div>

                    <!-- Metode Pembayaran -->
                    <div class="mb-6">
                        <label class="block text-gray-700 font-semibold mb-3">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition @error('metode_pembayaran') border-red-500 @enderror">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran" 
                                    value="transfer" 
                                    {{ old('metode_pembayaran') == 'transfer' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600"
                                    required
                                >
                                <div class="ml-3 flex items-center justify-between flex-1">
                                    <div>
                                        <span class="font-semibold text-gray-900">Transfer Bank</span>
                                        <p class="text-sm text-gray-500">Transfer melalui rekening bank</p>
                                    </div>
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran" 
                                    value="e-wallet" 
                                    {{ old('metode_pembayaran') == 'e-wallet' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600"
                                    required
                                >
                                <div class="ml-3 flex items-center justify-between flex-1">
                                    <div>
                                        <span class="font-semibold text-gray-900">E-Wallet</span>
                                        <p class="text-sm text-gray-500">GoPay, OVO, Dana, dll</p>
                                    </div>
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran" 
                                    value="kartu kredit" 
                                    {{ old('metode_pembayaran') == 'kartu kredit' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600"
                                    required
                                >
                                <div class="ml-3 flex items-center justify-between flex-1">
                                    <div>
                                        <span class="font-semibold text-gray-900">Kartu Kredit</span>
                                        <p class="text-sm text-gray-500">Visa, Mastercard, JCB</p>
                                    </div>
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                </div>
                            </label>
                        </div>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms & Conditions -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" required class="w-4 h-4 text-blue-600 mt-1 mr-2">
                            <span class="text-sm text-gray-600">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:underline">syarat dan ketentuan</a> yang berlaku
                            </span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <a href="{{ route('donations.show', $campaign->id) }}" 
                           class="flex-1 text-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                            Batal
                        </a>
                        <button 
                            type="submit" 
                            class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-lg">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Campaign Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h3 class="font-semibold text-gray-900 mb-4">Detail Kampanye</h3>
                
                <div class="h-32 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mb-4">
                    <span class="text-white text-4xl">💙</span>
                </div>

                <h4 class="font-bold text-gray-900 mb-2">{{ $campaign->judul }}</h4>
                <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ $campaign->deskripsi }}</p>

                <div class="border-t pt-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Target</span>
                        <span class="font-semibold">Rp {{ number_format($campaign->target_donasi, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Terkumpul</span>
                        <span class="font-semibold text-blue-600">Rp {{ number_format($campaign->terkumpul, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Status</span>
                        <span class="font-semibold text-green-600">{{ ucfirst($campaign->status) }}</span>
                    </div>
                </div>

                <div class="mt-4 p-3 bg-blue-50 rounded-lg">
                    <p class="text-xs text-gray-600 mb-1">💡 Tips</p>
                    <p class="text-sm text-gray-700">Donasi Anda akan sangat membantu tercapainya target kampanye ini</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setAmount(amount) {
    document.querySelector('input[name="jumlah"]').value = amount;
}
</script>
@endsectio