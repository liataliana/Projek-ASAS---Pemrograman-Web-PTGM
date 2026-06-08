<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-rentals-title">📋 Admin: Kelola Peminjaman</h2>
    </x-slot>

    <div class="admin-rentals-container">
        <div class="admin-rentals-card">
            <!-- Header -->
            <div class="card-header-rentals">
                <div class="header-left">
                    <span class="header-icon">📦</span>
                    <div>
                        <h3>Daftar Peminjaman</h3>
                        <p>Kelola dan konfirmasi peminjaman produk oleh pengguna</p>
                    </div>
                </div>
                <div class="stats-badge">
                    <span class="stat-waiting">{{ $rentals->where('status', 'waiting')->count() }} Menunggu</span>
                    <span class="stat-active">{{ $rentals->where('status', 'active')->count() }} Aktif</span>
                    <span class="stat-expired">{{ $rentals->where('status', 'expired')->count() }} Expired</span>
                </div>
            </div>

            @if($rentals->isEmpty())
                <div class="empty-rentals-state">
                    <div class="empty-icon">📭</div>
                    <h4>Belum Ada Peminjaman</h4>
                    <p>Belum ada pengguna yang melakukan peminjaman</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="rentals-table">
                        <thead>
                            <tr>
                                <th>👤 Pengguna</th>
                                <th>🎮 Produk</th>
                                <th>⏱️ Durasi</th>
                                <th>📌 Status</th>
                                <th>📅 Waktu Sewa</th>
                                <th>⚡ Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                                <tr class="rental-row">
                                    <td class="user-cell">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ substr($rental->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="user-name">{{ $rental->user->name }}</div>
                                                <div class="user-email">{{ $rental->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-cell">
                                        <div class="product-info-rental">
                                            <span class="product-icon-rental">
                                                @if($rental->product->type == 'game') 🎮 @else 📱 @endif
                                            </span>
                                            <span>{{ $rental->product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="duration-cell">
                                        <div class="duration-badge">
                                            {{ $rental->duration_value }} 
                                            {{ $rental->duration_unit === 'hours' ? 'Jam' : 'Hari' }}
                                        </div>
                                    </td>
                                    <td class="status-cell">
                                        @if($rental->status === 'waiting')
                                            <span class="status-badge status-waiting">
                                                ⏳ Menunggu Konfirmasi
                                            </span>
                                        @elseif($rental->status === 'active')
                                            <span class="status-badge status-active">
                                                ✅ Aktif
                                            </span>
                                        @else
                                            <span class="status-badge status-expired">
                                                ❌ Expired
                                            </span>
                                        @endif
                                    </td>
                                    <td class="time-cell">
                                        @if($rental->start_time && $rental->end_time)
                                            <div class="time-info">
                                                <div>Mulai: {{ \Carbon\Carbon::parse($rental->start_time)->format('d/m/Y H:i') }}</div>
                                                <div>Selesai: {{ \Carbon\Carbon::parse($rental->end_time)->format('d/m/Y H:i') }}</div>
                                            </div>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="action-cell">
                                        @if($rental->status === 'waiting')
                                            <form method="POST" action="{{ route('admin.rentals.confirm', $rental) }}" class="confirm-form">
                                                @csrf
                                                <input type="hidden" name="start_time" value="{{ now()->format('Y-m-d H:i:s') }}">
                                                <button type="submit" class="btn-confirm" onclick="return confirm('Konfirmasi peminjaman ini?')">
                                                    ✅ Konfirmasi & Mulai
                                                </button>
                                            </form>
                                        @elseif($rental->status === 'active')
                                            <span class="badge-processed">Sudah Aktif</span>
                                        @else
                                            <span class="badge-processed expired-label">Telah Berakhir</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer -->
                <div class="table-footer-rentals">
                    <div class="total-rentals">
                        <span>📊 Total Peminjaman:</span>
                        <strong>{{ $rentals->count() }} peminjaman</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* ===== HEADER ===== */
        .admin-rentals-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .admin-rentals-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .admin-rentals-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* ===== CARD HEADER ===== */
        .card-header-rentals {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            font-size: 2rem;
        }

        .header-left h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin: 0 0 0.2rem 0;
        }

        .header-left p {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        /* ===== STATS BADGE ===== */
        .stats-badge {
            display: flex;
            gap: 0.75rem;
        }

        .stat-waiting, .stat-active, .stat-expired {
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
        }

        .stat-waiting { border-left: 3px solid #f59e0b; }
        .stat-active { border-left: 3px solid #10b981; }
        .stat-expired { border-left: 3px solid #ef4444; }

        /* ===== TABLE ===== */
        .table-responsive {
            overflow-x: auto;
        }

        .rentals-table {
            width: 100%;
            border-collapse: collapse;
        }

        .rentals-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .rentals-table th {
            padding: 1rem 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .rentals-table td {
            padding: 1rem 1rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .rental-row:hover {
            background: #fafafa;
        }

        /* ===== USER CELL ===== */
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1rem;
        }

        .user-name {
            font-weight: 600;
            color: #1f2937;
        }

        .user-email {
            font-size: 0.7rem;
            color: #6b7280;
        }

        /* ===== PRODUCT CELL ===== */
        .product-info-rental {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .product-icon-rental {
            font-size: 1.2rem;
        }

        /* ===== DURATION CELL ===== */
        .duration-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: #e0e7ff;
            color: #4338ca;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* ===== STATUS CELL ===== */
        .status-badge {
            display: inline-block;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .status-waiting {
            background: #fef3c7;
            color: #d97706;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-expired {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ===== TIME CELL ===== */
        .time-info {
            font-size: 0.7rem;
            color: #4b5563;
            line-height: 1.4;
        }

        .text-muted {
            color: #9ca3af;
        }

        /* ===== ACTION CELL ===== */
        .btn-confirm {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-confirm:hover {
            opacity: 0.9;
            transform: scale(0.95);
        }

        .badge-processed {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: #f3f4f6;
            color: #6b7280;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .expired-label {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ===== TABLE FOOTER ===== */
        .table-footer-rentals {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .total-rentals {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .total-rentals strong {
            color: #1f2937;
        }

        /* ===== EMPTY STATE ===== */
        .empty-rentals-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-rentals-state h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-rentals-state p {
            color: #6b7280;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .admin-rentals-container {
                padding: 1rem;
            }
            
            .card-header-rentals {
                flex-direction: column;
                text-align: center;
            }
            
            .header-left {
                flex-direction: column;
                text-align: center;
            }
            
            .stats-badge {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .rentals-table th, 
            .rentals-table td {
                padding: 0.75rem 0.5rem;
            }
            
            .user-info {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</x-app-layout>