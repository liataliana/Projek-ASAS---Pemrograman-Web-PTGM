<x-app-layout>
    <x-slot name="header">
        <h2 class="rentals-title">📋 Riwayat Sewa Saya</h2>
    </x-slot>

    <div class="rentals-container">
        @if($rentals->isEmpty())
            <div class="empty-rentals-card">
                <div class="empty-icon">📭</div>
                <h3>Belum Ada Peminjaman</h3>
                <p>Anda belum pernah menyewa produk apapun. Yuk mulai sewa!</p>
                <a href="{{ route('products.index') }}" class="empty-rentals-btn">
                    🛒 Lihat Produk
                </a>
            </div>
        @else
            <!-- STATS SUMMARY -->
            <div class="rentals-stats">
                <div class="stat-item">
                    <span class="stat-label">Total Sewa</span>
                    <span class="stat-number">{{ $rentals->count() }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Aktif</span>
                    <span class="stat-number active-count">{{ $rentals->where('status', 'active')->count() }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Menunggu</span>
                    <span class="stat-number waiting-count">{{ $rentals->where('status', 'waiting')->count() }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Expired</span>
                    <span class="stat-number expired-count">{{ $rentals->where('status', 'expired')->count() }}</span>
                </div>
            </div>

            <!-- RENTALS LIST -->
            <div class="rentals-list">
                @foreach($rentals as $rental)
                    <div class="rental-card">
                        <div class="rental-header">
                            <div class="product-type-icon">
                                @if($rental->product->type == 'game') 🎮 @else 📱 @endif
                            </div>
                            <div class="product-title">
                                <h3>{{ $rental->product->name }}</h3>
                                <span class="duration-badge">
                                    {{ $rental->duration_value }} {{ $rental->duration_unit === 'hours' ? 'Jam' : 'Hari' }}
                                </span>
                            </div>
                            <div class="status-badge-rental">
                                @if($rental->status === 'waiting')
                                    <span class="status waiting">⏳ Menunggu Konfirmasi</span>
                                @elseif($rental->status === 'active')
                                    <span class="status active">✅ Aktif</span>
                                @else
                                    <span class="status expired">❌ Kadaluarsa</span>
                                @endif
                            </div>
                        </div>

                        <div class="rental-body">
                            <div class="info-row">
                                <div class="info-label">📅 Tanggal Sewa</div>
                                <div class="info-value">{{ $rental->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            
                            @if($rental->start_time && $rental->end_time)
                                <div class="info-row">
                                    <div class="info-label">⏰ Masa Aktif</div>
                                    <div class="info-value">
                                        {{ \Carbon\Carbon::parse($rental->start_time)->format('d/m/Y H:i') }}
                                        <span class="arrow">→</span>
                                        {{ \Carbon\Carbon::parse($rental->end_time)->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                
                                <!-- Progress Bar -->
                                @if($rental->status === 'active')
                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $start = \Carbon\Carbon::parse($rental->start_time);
                                        $end = \Carbon\Carbon::parse($rental->end_time);
                                        $total = $start->diffInSeconds($end);
                                        $elapsed = $start->diffInSeconds($now);
                                        $percentage = min(100, max(0, ($elapsed / $total) * 100));
                                    @endphp
                                    <div class="progress-section">
                                        <div class="progress-label">
                                            <span>Sisa waktu sewa</span>
                                            <span>{{ $now->diffInHours($end) }} jam lagi</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: {{ 100 - $percentage }}%;"></div>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="info-row">
                                    <div class="info-label">⏰ Masa Aktif</div>
                                    <div class="info-value muted">Menunggu konfirmasi admin</div>
                                </div>
                            @endif
                        </div>

                        <div class="rental-footer">
                            @if($rental->status === 'active')
                                <a href="{{ $rental->product->link }}" target="_blank" class="btn-access">
                                    🔗 Download / Akses Produk
                                </a>
                            @elseif($rental->status === 'waiting')
                                <div class="waiting-info">
                                    <span>⏳</span>
                                    <span>Menunggu konfirmasi dari admin</span>
                                </div>
                            @else
                                <div class="expired-info">
                                    <span>❌</span>
                                    <span>Masa sewa telah berakhir</span>
                                    <a href="{{ route('products.index') }}" class="btn-rent-again">Sewa Lagi</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        /* ===== HEADER ===== */
        .rentals-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .rentals-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ===== EMPTY STATE ===== */
        .empty-rentals-card {
            background: white;
            border-radius: 28px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-rentals-card h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-rentals-card p {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-rentals-btn {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .empty-rentals-btn:hover {
            transform: scale(0.98);
            opacity: 0.9;
        }

        /* ===== STATS ===== */
        .rentals-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-item {
            background: white;
            border-radius: 20px;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .stat-label {
            display: block;
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.25rem;
        }

        .stat-number {
            display: block;
            font-size: 1.8rem;
            font-weight: 800;
            color: #1f2937;
        }

        .stat-number.active-count { color: #10b981; }
        .stat-number.waiting-count { color: #f59e0b; }
        .stat-number.expired-count { color: #ef4444; }

        /* ===== RENTALS LIST ===== */
        .rentals-list {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .rental-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: all 0.2s;
        }

        .rental-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        /* ===== RENTAL HEADER ===== */
        .rental-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.25rem 1.5rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }

        .product-type-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .product-title {
            flex: 1;
        }

        .product-title h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 0.25rem 0;
        }

        .duration-badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            background: #e2e8f0;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            color: #475569;
        }

        .status-badge-rental .status {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status.waiting { background: #fef3c7; color: #d97706; }
        .status.active { background: #dcfce7; color: #166534; }
        .status.expired { background: #fee2e2; color: #dc2626; }

        /* ===== RENTAL BODY ===== */
        .rental-body {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7280;
        }

        .info-value {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1f2937;
        }

        .info-value .arrow {
            margin: 0 0.5rem;
            color: #9ca3af;
        }

        .info-value.muted {
            color: #9ca3af;
            font-weight: normal;
        }

        /* ===== PROGRESS BAR ===== */
        .progress-section {
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e2e8f0;
        }

        .progress-label {
            display: flex;
            justify-content: space-between;
            font-size: 0.7rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .progress-bar {
            height: 6px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #059669);
            border-radius: 10px;
            transition: width 0.3s ease;
        }

        /* ===== RENTAL FOOTER ===== */
        .rental-footer {
            padding: 1rem 1.5rem;
            background: #fafafa;
        }

        .btn-access {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 0.75rem 1.25rem;
            border-radius: 50px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-access:hover {
            transform: scale(0.98);
            opacity: 0.9;
        }

        .waiting-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #d97706;
            font-size: 0.8rem;
        }

        .expired-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
            color: #6b7280;
            font-size: 0.8rem;
        }

        .btn-rent-again {
            background: #e2e8f0;
            color: #1f2937;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-rent-again:hover {
            background: #cbd5e1;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .rentals-container {
                padding: 1rem;
            }
            
            .rental-header {
                flex-direction: column;
                text-align: center;
            }
            
            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .rentals-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</x-app-layout>