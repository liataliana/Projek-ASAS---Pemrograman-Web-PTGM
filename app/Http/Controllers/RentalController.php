<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // Admin: lihat semua peminjaman
    public function index()
    {
        $rentals = Rental::with(['user', 'product'])->latest()->get();
        return view('admin.rentals.index', compact('rentals'));
    }

    // User: form sewa produk
    public function create(Product $product)
    {
        return view('rentals.create', compact('product'));
    }

    // User: simpan peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days',
        ]);

        Rental::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'duration_value' => $request->duration_value,
            'duration_unit' => $request->duration_unit,
            'status' => 'waiting',
        ]);

        return redirect()->route('rentals.my')->with('success', 'Peminjaman berhasil dibuat, menunggu konfirmasi admin');
    }

    // User: lihat riwayat sewa sendiri
    public function myRentals()
    {
        $rentals = Rental::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Cek expired untuk setiap rental yang status active
        foreach ($rentals as $rental) {
            if ($rental->status === 'active' && $rental->end_time && Carbon::now()->greaterThan($rental->end_time)) {
                $rental->status = 'expired';
                $rental->save();
            }
        }

        return view('rentals.my', compact('rentals'));
    }

    // Admin: konfirmasi peminjaman
    public function confirm(Request $request, Rental $rental)
    {
        $request->validate([
            'start_time' => 'required|date',
        ]);

        $startTime = Carbon::parse($request->start_time);
        
        // Hitung end_time berdasarkan durasi
        if ($rental->duration_unit === 'hours') {
            $endTime = $startTime->copy()->addHours($rental->duration_value);
        } else {
            $endTime = $startTime->copy()->addDays($rental->duration_value);
        }

        $rental->update([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'active',
        ]);

        return redirect()->route('admin.rentals.index')->with('success', 'Peminjaman dikonfirmasi');
    }
}