<x-app-layout>
    <x-slot name="header">
        <h2 class="user-dashboard-title">👋 Dashboard Pembeli</h2>
    </x-slot>

    <div class="user-dashboard-container">
        
        <!-- WELCOME CARD -->
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h3>Halo, {{ Auth::user()->name }}! 👋</h3>
                    <p>Selamat datang di KlikRental. Yuk mulai sewa game atau aplikasi Android favoritmu!</p>
                </div>
                <div class="welcome-icon">🎮</div>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="stats-grid-user">
            <div class="stat-card-user">
                <div class="stat-icon-user blue">📦</div>
                <div class="stat-info-user">
                    <h3>Total Sewa</h3>
                    <div class="stat-value-user">{{ $totalRentals ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card-user">
                <div class="stat-icon-user green">✅</div>
                <div class="stat-info-user">
                    <h3>Aktif</h3>
                    <div class="stat-value-user">{{ $activeRentals ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card-user">
                <div class="stat-icon-user orange">⏳</div>
                <div class="stat-info-user">
                    <h3>Menunggu</h3>
                    <div class="stat-value-user">{{ $waitingRentals ?? 0 }}</div>
                </div>
            </div>
            <div class="stat-card-user">
                <div class="stat-icon-user red">❌</div>
                <div class="stat-info-user">
                    <h3>Expired</h3>
                    <div class="stat-value-user">{{ $expiredRentals ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- SEWA AKTIF (PENTING!) -->
        @if(($activeRentals ?? 0) > 0)
        <div class="active-rentals-card">
            <div class="card-header-user">
                <span class="header-icon">🔥</span>
                <h3>Sedang Berjalan</h3>
                <span class="badge-active">{{ $activeRentals }} aktif</span>
            </div>
            <div class="active-rentals-list">
                @foreach($activeRentalsList ?? [] as $rental)
                <div class="active-rental-item">
                    <div class="active-rental-icon">
                        @if($rental->product->type == 'game') 🎮 @else 📱 @endif
                    </div>
                    <div class="active-rental-info">
                        <div class="active-rental-name">{{ $rental->product->name }}</div>
                        <div class="active-rental-time">
                            ⏰ Sisa: 
                            @php
                                $end = \Carbon\Carbon::parse($rental->end_time);
                                $now = \Carbon\Carbon::now();
                                $hoursLeft = $now->diffInHours($end, false);
                            @endphp
                            @if($hoursLeft > 24)
                                {{ round($hoursLeft / 24) }} hari lagi
                            @elseif($hoursLeft > 0)
                                {{ $hoursLeft }} jam lagi
                            @else
                                <span class="expiring-soon">Segera berakhir!</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ $rental->product->link }}" target="_blank" class="btn-access-small">Akses →</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- NOTIFIKASI (SEWA MENUNGGU) -->
        @if(($waitingRentals ?? 0) > 0)
        <div class="waiting-alert">
            <div class="alert-icon">⏳</div>
            <div class="alert-text">
                <strong>{{ $waitingRentals }} peminjaman</strong> sedang menunggu konfirmasi admin.
            </div>
            <a href="{{ route('rentals.my') }}" class="alert-link">Lihat →</a>
        </div>
        @endif

        <!-- PEMINJAMAN TERBARU -->
        <div class="recent-rentals-card">
            <div class="card-header-user">
                <span class="header-icon">🕐</span>
                <h3>Peminjaman Terbaru</h3>
                <a href="{{ route('rentals.my') }}" class="view-all-link">Lihat Semua →</a>
            </div>
            <div class="recent-rentals-list">
                @forelse($recentRentals ?? [] as $rental)
                <div class="recent-item">
                    <div class="recent-icon">@if($rental->product->type == 'game') 🎮 @else 📱 @endif</div>
                    <div class="recent-info">
                        <div class="recent-name">{{ $rental->product->name }}</div>
                        <div class="recent-date">{{ $rental->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="recent-status">
                        @if($rental->status == 'waiting')
                            <span class="status-badge waiting">Menunggu</span>
                        @elseif($rental->status == 'active')
                            <span class="status-badge active">Aktif</span>
                        @else
                            <span class="status-badge expired">Expired</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="empty-recent">
                    <span>📭</span>
                    <p>Belum ada peminjaman</p>
                    <a href="{{ route('products.index') }}" class="btn-shop">Mulai Belanja</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- REKOMENDASI / AKSI CEPAT -->
        <div class="quick-actions-card">
            <div class="card-header-user">
                <span class="header-icon">⚡</span>
                <h3>Aksi Cepat</h3>
            </div>
            <div class="actions-grid">
                <a href="{{ route('products.index') }}" class="action-btn">🛒 Lihat Produk</a>
                <a href="{{ route('cart.view') }}" class="action-btn">🛍️ Keranjang Saya</a>
                <a href="{{ route('rentals.my') }}" class="action-btn">📋 Riwayat Sewa</a>
            </div>
        </div>

    </div>

    <style>
        .user-dashboard-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        .user-dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* WELCOME CARD */
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 28px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .welcome-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .welcome-text h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin: 0 0 0.5rem 0;
        }
        .welcome-text p {
            font-size: 0.85rem;
            color: rgba(255,255,255,0.85);
        }
        .welcome-icon { font-size: 4rem; }

        /* STATS */
        .stats-grid-user {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .stat-card-user {
            background: white;
            border-radius: 20px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .stat-icon-user {
            width: 50px;
            height: 50px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .stat-icon-user.blue { background: #dbeafe; }
        .stat-icon-user.green { background: #dcfce7; }
        .stat-icon-user.orange { background: #fef3c7; }
        .stat-icon-user.red { background: #fee2e2; }
        .stat-info-user h3 { font-size: 0.7rem; color: #6b7280; margin: 0; }
        .stat-value-user { font-size: 1.5rem; font-weight: 800; color: #1f2937; }

        /* ACTIVE RENTALS */
        .active-rentals-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            border-left: 4px solid #10b981;
        }
        .badge-active {
            background: #dcfce7;
            color: #166534;
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.7rem;
        }
        .active-rentals-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .active-rental-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 16px;
        }
        .active-rental-icon {
            width: 40px;
            height: 40px;
            background: #e0e7ff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .active-rental-info { flex: 1; }
        .active-rental-name { font-weight: 600; font-size: 0.9rem; }
        .active-rental-time { font-size: 0.7rem; color: #6b7280; }
        .expiring-soon { color: #ef4444; font-weight: 600; }
        .btn-access-small {
            background: #3b82f6;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            text-decoration: none;
            font-size: 0.7rem;
        }

        /* ALERT */
        .waiting-alert {
            background: #fef3c7;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f59e0b;
        }
        .alert-icon { font-size: 1.5rem; }
        .alert-text { flex: 1; font-size: 0.85rem; color: #92400e; }
        .alert-link { color: #d97706; text-decoration: none; font-weight: 600; }

        /* RECENT */
        .recent-rentals-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .card-header-user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        .card-header-user h3 { flex: 1; font-size: 1rem; margin: 0; }
        .view-all-link { font-size: 0.75rem; color: #3b82f6; text-decoration: none; }
        .recent-rentals-list { display: flex; flex-direction: column; gap: 0.75rem; }
        .recent-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.5rem;
        }
        .recent-icon {
            width: 36px;
            height: 36px;
            background: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }
        .recent-info { flex: 1; }
        .recent-name { font-weight: 500; font-size: 0.85rem; }
        .recent-date { font-size: 0.65rem; color: #94a3b8; }
        .status-badge {
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
        }
        .status-badge.waiting { background: #fef3c7; color: #d97706; }
        .status-badge.active { background: #dcfce7; color: #166534; }
        .status-badge.expired { background: #fee2e2; color: #dc2626; }

        /* QUICK ACTIONS */
        .quick-actions-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .actions-grid {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .action-btn {
            flex: 1;
            background: #f8fafc;
            padding: 0.75rem;
            border-radius: 16px;
            text-align: center;
            text-decoration: none;
            color: #1f2937;
            font-weight: 500;
            font-size: 0.85rem;
            transition: 0.2s;
        }
        .action-btn:hover { background: #e2e8f0; transform: translateY(-2px); }
        .empty-recent { text-align: center; padding: 1.5rem; }
        .btn-shop {
            display: inline-block;
            background: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            text-decoration: none;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        @media (max-width: 768px) {
            .user-dashboard-container { padding: 1rem; }
            .welcome-content { flex-direction: column; text-align: center; }
            .stats-grid-user { grid-template-columns: repeat(2, 1fr); }
            .actions-grid { flex-direction: column; }
        }
    </style>
</x-app-layout>