<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;

class UserController extends Controller
{
    // Menampilkan halaman profil user
    public function profile()
    {
        return view('profile.index');
    }

    // Melengkapi profil customer untuk user
    public function completeProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'address' => 'required|string|max:500',
        ]);

        // Periksa apakah user sudah memiliki customer profile
        $existingCustomer = Customer::where('user_id', $user->id)->first();
        
        if ($existingCustomer) {
            // Update alamat untuk customer yang sudah ada
            $existingCustomer->update([
                'address' => $validated['address'],
            ]);
            return redirect()->route('user.profile')->with('success', 'Alamat berhasil diperbarui! Anda sekarang dapat membuat pesanan.');
        } else {
            // Buat customer profile baru untuk user
            Customer::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'address' => $validated['address'],
            ]);
            return redirect()->route('user.profile')->with('success', 'Profil pelanggan berhasil dilengkapi! Anda sekarang dapat membuat pesanan.');
        }
    }

    // Menampilkan halaman pengaturan user
    public function settings()
    {
        return view('settings.coming-soon');
    }

    // Memperbarui pengaturan user
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('user.settings')->with('success', 'Pengaturan berhasil diperbarui.');
    }
}