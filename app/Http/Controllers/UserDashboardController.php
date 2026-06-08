<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Product;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Statistik
        $totalRentals = Rental::where('user_id', $user->id)->count();
        $activeRentals = Rental::where('user_id', $user->id)->where('status', 'active')->count();
        $waitingRentals = Rental::where('user_id', $user->id)->where('status', 'waiting')->count();
        $expiredRentals = Rental::where('user_id', $user->id)->where('status', 'expired')->count();
        
        // Sewa aktif (yang lagi jalan)
        $activeRentalsList = Rental::with('product')
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->get();
        
        // Peminjaman terbaru (5 terakhir)
        $recentRentals = Rental::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Rekomendasi produk (opsional: produk populer atau random)
        $recommendedProducts = Product::inRandomOrder()->take(4)->get();
        
        return view('user.dashboard', compact(
            'totalRentals',
            'activeRentals',
            'waitingRentals',
            'expiredRentals',
            'activeRentalsList',
            'recentRentals',
            'recommendedProducts'
        ));
    }
}