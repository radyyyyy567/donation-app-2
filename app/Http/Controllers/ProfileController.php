<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function show()
    {
        $user = Auth::user();
        
        // Get donation statistics
        $totalDonations = $user->donations()->count();
        $successDonations = $user->donations()->where('status', 'sukses')->count();
        $totalAmount = $user->donations()->where('status', 'sukses')->sum('jumlah');
        
        // Get recent donations
        $recentDonations = $user->donations()
            ->with('campaign')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        // Get campaigns user has donated to
        $campaigns = $user->donations()
            ->where('status', 'sukses')
            ->with('campaign')
            ->get()
            ->pluck('campaign')
            ->unique('id');
        
        return view('profile.show', compact(
            'user',
            'totalDonations',
            'successDonations',
            'totalAmount',
            'recentDonations',
            'campaigns'
        ));
    }

    /**
     * Show the form for editing the profile
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:225'],
            'email' => ['required', 'string', 'email', 'max:225', 'unique:users,email,' . $user->id],
            'no_telp' => ['required', 'string', 'max:225'],
            'alamat' => ['required', 'string', 'max:225'],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'no_telp.required' => 'Nomor telepon wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
        ]);

        $user->update($validated);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Password lama wajib diisi',
            'password.required' => 'Password baru wajib diisi',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                ->withInput();
        }

        // Update password
        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('profile.show')
            ->with('success', 'Password berhasil diubah!');
    }

    /**
     * Delete the user's account
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ], [
            'password.required' => 'Password wajib diisi untuk menghapus akun',
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return back()
                ->withErrors(['password' => 'Password tidak sesuai'])
                ->withInput();
        }

        // Check if user has pending donations
        $pendingDonations = $user->donations()->where('status', 'pending')->count();
        
        if ($pendingDonations > 0) {
            return back()
                ->with('error', 'Tidak dapat menghapus akun. Anda masih memiliki donasi yang pending.');
        }

        // Logout and delete account
        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Akun Anda telah berhasil dihapus.');
    }
}