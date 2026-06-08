<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pendapatan (join dengan products untuk ambil price)
        $totalRevenue = Rental::whereIn('rentals.status', ['active', 'expired'])
            ->join('products', 'rentals.product_id', '=', 'products.id')
            ->sum('products.price') ?? 0;
        
        // Total peminjaman
        $totalRentals = Rental::count();
        
        // Pengguna aktif (yang pernah menyewa)
        $activeUsers = Rental::distinct('user_id')->count('user_id');
        
        // Total produk
        $totalProducts = Product::count();
        $gameCount = Product::where('type', 'game')->count();
        $androidCount = Product::where('type', 'android')->count();
        
        // Status peminjaman
        $waitingRentals = Rental::where('status', 'waiting')->count();
        $activeRentals = Rental::where('status', 'active')->count();
        $expiredRentals = Rental::where('status', 'expired')->count();
        
        // Peminjaman terbaru (5 terakhir)
        $recentRentals = Rental::with(['user', 'product'])
            ->latest()
            ->take(5)
            ->get();
        
        // Data chart (30 hari terakhir)
        $chartLabels = [];
        $chartData = [];
        
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d/m');
            $count = Rental::whereDate('created_at', $date->toDateString())->count();
            $chartData[] = $count;
        }
        
        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalRentals',
            'activeUsers',
            'totalProducts',
            'gameCount',
            'androidCount',
            'waitingRentals',
            'activeRentals',
            'expiredRentals',
            'recentRentals',
            'chartLabels',
            'chartData'
        ));
    }
}