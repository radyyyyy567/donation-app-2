<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\DonationLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    /**
     * Display a listing of campaigns
     */
    public function index(Request $request)
    {
        $query = Campaign::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default to show only active campaigns
            $query->where('status', 'aktif');
        }

        // Order by latest
        $query->orderBy('created_at', 'desc');

        $campaigns = $query->paginate(9);

        return view('donations.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new donation
     */
    public function create($campaignId)
    {
        $campaign = Campaign::findOrFail($campaignId);

        // Check if campaign is active
        if ($campaign->status !== 'aktif') {
            return redirect()
                ->route('donations.show', $campaign->id)
                ->with('error', 'Kampanye ini sudah tidak aktif.');
        }

        return view('donations.create', compact('campaign'));
    }

    /**
     * Store a newly created donation
     */
    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'jumlah' => 'required|numeric|min:10000',
            'metode_pembayaran' => 'required|in:transfer,e-wallet,kartu kredit',
        ], [
            'jumlah.required' => 'Nominal donasi harus diisi',
            'jumlah.min' => 'Minimal donasi adalah Rp 10.000',
            'metode_pembayaran.required' => 'Pilih metode pembayaran',
        ]);
        
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk melakukan donasi.');
        }

        $campaign = Campaign::findOrFail($validated['campaign_id']);

        // Check if campaign is still active
        if ($campaign->status !== 'aktif') {
            return redirect()
                ->route('donations.show', $campaign->id)
                ->with('error', 'Kampanye ini sudah tidak aktif.');
        }

        DB::beginTransaction();
        try {
            // Create donation with pending status
            $donation = Donation::create([
                'user_id' => Auth::id(),
                'campaign_id' => $validated['campaign_id'],
                'jumlah' => $validated['jumlah'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status' => 'pending',
                'tanggal' => now(),
            ]);

            // Create initial donation log
            DonationLog::create([
                'donation_id' => $donation->id,
                'waktu_update' => now(),
                'status' => 'pending',
            ]);

            DB::commit();

            // Redirect to payment page (you can customize this)
            return redirect()
                ->route('donations.payment', $donation->id)
                ->with('success', 'Donasi berhasil dibuat. Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified campaign
     */
    public function show($id)
    {
        $campaign = Campaign::with(['campaign_owner.organization'])->findOrFail($id);
        
        // Calculate percentage
        $percentage = $campaign->target_donasi > 0 
            ? ($campaign->terkumpul / $campaign->target_donasi) * 100 
            : 0;

        // Get recent donations for this campaign
        $recentDonations = Donation::where('campaign_id', $id)
            ->where('status', 'sukses')
            ->with('user')
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();

        return view('donations.show', compact('campaign', 'percentage', 'recentDonations'));
    }

    /**
     * Display payment page
     */
    public function payment($donationId)
    {
        $donation = Donation::with(['campaign', 'user'])
            ->where('id', $donationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if donation is still pending
        if ($donation->status !== 'pending') {
            return redirect()
                ->route('donations.show', $donation->campaign_id)
                ->with('error', 'Donasi ini sudah diproses.');
        }

        return view('donations.payment', compact('donation'));
    }

    /**
     * Process payment (simulate payment gateway)
     */
    public function processPayment(Request $request, $donationId)
    {
        $donation = Donation::where('id', $donationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if donation is still pending
        if ($donation->status !== 'pending') {
            return redirect()
                ->route('donations.show', $donation->campaign_id)
                ->with('error', 'Donasi ini sudah diproses.');
        }

        DB::beginTransaction();
        try {
            // Update donation status to success
            $donation->update(['status' => 'sukses']);

            // Update campaign collected amount
            $campaign = Campaign::findOrFail($donation->campaign_id);
            $campaign->increment('terkumpul', $donation->jumlah);

            // Check if target is reached
            if ($campaign->terkumpul >= $campaign->target_donasi) {
                $campaign->update(['status' => 'selesai']);
            }

            // Create donation log
            DonationLog::create([
                'donation_id' => $donation->id,
                'waktu_update' => now(),
                'status' => 'sukses',
            ]);

            DB::commit();

            return redirect()
                ->route('donations.success', $donation->id)
                ->with('success', 'Pembayaran berhasil! Terima kasih atas donasi Anda.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Update donation status to failed
            $donation->update(['status' => 'gagal']);

            // Create donation log
            DonationLog::create([
                'donation_id' => $donation->id,
                'waktu_update' => now(),
                'status' => 'gagal',
            ]);

            return redirect()
                ->back()
                ->with('error', 'Pembayaran gagal. Silakan coba lagi.');
        }
    }

    /**
     * Display success page
     */
    public function success($donationId)
    {
        $donation = Donation::with(['campaign', 'user'])
            ->where('id', $donationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('donations.success', compact('donation'));
    }

    /**
     * Display user's donation history
     */
    public function myDonations(Request $request)
    {
        $query = Donation::where('user_id', Auth::id())
            ->with('campaign');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $donations = $query->orderBy('tanggal', 'desc')->paginate(10);

        // Calculate statistics
        $successCount = Donation::where('user_id', Auth::id())
            ->where('status', 'sukses')
            ->count();

        $pendingCount = Donation::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $failedCount = Donation::where('user_id', Auth::id())
            ->where('status', 'gagal')
            ->count();

        $totalAmount = Donation::where('user_id', Auth::id())
            ->where('status', 'sukses')
            ->sum('jumlah');

        return view('donations.my-donations', compact(
            'donations',
            'successCount',
            'pendingCount',
            'failedCount',
            'totalAmount'
        ));
    }

    /**
     * Download donation receipt (optional feature)
     */
    public function downloadReceipt($donationId)
    {
        $donation = Donation::with(['campaign', 'user'])
            ->where('id', $donationId)
            ->where('user_id', Auth::id())
            ->where('status', 'sukses')
            ->firstOrFail();

        // Here you can implement PDF generation
        // For now, we'll just return a view that can be printed
        return view('donations.receipt', compact('donation'));
    }
}