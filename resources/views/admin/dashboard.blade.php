<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-dashboard-title">📊 Dashboard Admin</h2>
    </x-slot>

    <div class="admin-dashboard-container">
        <!-- STATS CARDS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon purple">
                    <span>💰</span>
                </div>
                <div class="stat-info">
                    <h3>Total Pendapatan</h3>
                    <div class="stat-value">Rp {{ number_format($totalRevenue ?? 0) }}</div>
                    <p class="stat-desc">Dari semua peminjaman</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <span>📦</span>
                </div>
                <div class="stat-info">
                    <h3>Total Peminjaman</h3>
                    <div class="stat-value">{{ $totalRentals ?? 0 }}</div>
                    <p class="stat-desc">Seluruh waktu</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <span>👥</span>
                </div>
                <div class="stat-info">
                    <h3>Pengguna Aktif</h3>
                    <div class="stat-value">{{ $activeUsers ?? 0 }}</div>
                    <p class="stat-desc">Yang pernah menyewa</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon orange">
                    <span>🎮</span>
                </div>
                <div class="stat-info">
                    <h3>Total Produk</h3>
                    <div class="stat-value">{{ $totalProducts ?? 0 }}</div>
                    <p class="stat-desc">{{ $gameCount ?? 0 }} Game | {{ $androidCount ?? 0 }} Android</p>
                </div>
            </div>
        </div>

        <!-- CHART & RECENT TRANSACTIONS -->
        <div class="dashboard-grid">
            <!-- Grafik Peminjaman -->
            <div class="chart-card">
                <div class="card-header-dashboard">
                    <span class="header-icon">📈</span>
                    <h3>Statistik Peminjaman (30 Hari Terakhir)</h3>
                </div>
                <div class="chart-container">
                    <canvas id="rentalChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>

            <!-- Ringkasan Status Peminjaman -->
            <div class="status-card">
                <div class="card-header-dashboard">
                    <span class="header-icon">📋</span>
                    <h3>Ringkasan Status Peminjaman</h3>
                </div>
                <div class="status-list">
                    <div class="status-item">
                        <div class="status-label">
                            <span class="status-dot waiting"></span>
                            <span>Menunggu Konfirmasi</span>
                        </div>
                        <div class="status-number">{{ $waitingRentals ?? 0 }}</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">
                            <span class="status-dot active"></span>
                            <span>Sedang Berjalan (Aktif)</span>
                        </div>
                        <div class="status-number">{{ $activeRentals ?? 0 }}</div>
                    </div>
                    <div class="status-item">
                        <div class="status-label">
                            <span class="status-dot expired"></span>
                            <span>Selesai / Expired</span>
                        </div>
                        <div class="status-number">{{ $expiredRentals ?? 0 }}</div>
                    </div>
                </div>
                <div class="status-divider"></div>
                <div class="status-total">
                    <span>Total Keseluruhan</span>
                    <strong>{{ $totalRentals ?? 0 }} Peminjaman</strong>
                </div>
            </div>
        </div>

        <!-- Peminjaman Terbaru -->
        <div class="recent-card">
            <div class="card-header-dashboard">
                <span class="header-icon">🕐</span>
                <h3>Peminjaman Terbaru</h3>
                <a href="{{ route('admin.rentals.index') }}" class="view-all-link">Lihat Semua →</a>
            </div>
            <div class="table-responsive">
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>Pengguna</th>
                            <th>Produk</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRentals ?? [] as $rental)
                            <tr>
                                <td>
                                    <div class="recent-user">
                                        <div class="recent-avatar">{{ substr($rental->user->name, 0, 1) }}</div>
                                        <span>{{ $rental->user->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $rental->product->name }}</td>
                                <td>{{ $rental->duration_value }} {{ $rental->duration_unit === 'hours' ? 'Jam' : 'Hari' }}</td>
                                <td>
                                    @if($rental->status === 'waiting')
                                        <span class="status-badge-small waiting">Menunggu</span>
                                    @elseif($rental->status === 'active')
                                        <span class="status-badge-small active">Aktif</span>
                                    @else
                                        <span class="status-badge-small expired">Expired</span>
                                    @endif
                                </td>
                                <td>{{ $rental->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-table">Belum ada peminjaman</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        .status-badge-small.waiting { 
    background: #fef3c7; 
    color: #92400e; 
}
.status-badge-small.active { 
    background: #d1fae5; 
    color: #065f46; 
}
.status-badge-small.expired { 
    background: #fee2e2; 
    color: #991b1b; 
}
        /* ===== HEADER ===== */
        .admin-dashboard-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .admin-dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ===== STATS GRID ===== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .stat-icon.purple { background: linear-gradient(135deg, #667eea, #764ba2); }
        .stat-icon.green { background: linear-gradient(135deg, #10b981, #059669); }
        .stat-icon.blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .stat-icon.orange { background: linear-gradient(135deg, #f59e0b, #d97706); }

        .stat-info h3 {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7280;
            margin: 0 0 0.25rem 0;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #1f2937;
        }

        .stat-desc {
            font-size: 0.7rem;
            color: #9ca3af;
            margin: 0.25rem 0 0 0;
        }

        /* ===== DASHBOARD GRID ===== */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* ===== CHART CARD ===== */
        .chart-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .card-header-dashboard {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .card-header-dashboard .header-icon {
            font-size: 1.3rem;
        }

        .card-header-dashboard h3 {
            font-size: 1rem;
            font-weight: 600;
            color: #1f2937;
            margin: 0;
            flex: 1;
        }

        .view-all-link {
            font-size: 0.75rem;
            color: #3b82f6;
            text-decoration: none;
        }

        .view-all-link:hover {
            text-decoration: underline;
        }

        .chart-container {
            position: relative;
        }

        /* ===== STATUS CARD ===== */
        .status-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .status-list {
            margin-bottom: 1rem;
        }

        .status-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .status-item:last-child {
            border-bottom: none;
        }

        .status-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: #4b5563;
        }

        .status-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .status-dot.waiting { background: #f59e0b; }
        .status-dot.active { background: #10b981; }
        .status-dot.expired { background: #ef4444; }

        .status-number {
            font-weight: 700;
            font-size: 1.2rem;
            color: #1f2937;
        }

        .status-divider {
            height: 1px;
            background: linear-gradient(90deg, #e5e7eb, transparent);
            margin: 1rem 0;
        }

        .status-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: #4b5563;
        }

        .status-total strong {
            font-size: 1.1rem;
            color: #1f2937;
        }

        /* ===== RECENT CARD ===== */
        .recent-card {
            background: white;
            border-radius: 24px;
            padding: 1.25rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .recent-table {
            width: 100%;
            border-collapse: collapse;
        }

        .recent-table th {
            text-align: left;
            padding: 0.75rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5e7eb;
        }

        .recent-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
            color: #374151;
            border-bottom: 1px solid #f0f0f0;
        }

        .recent-table tr:hover {
            background: #fafafa;
        }

        .recent-user {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .recent-avatar {
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .status-badge-small {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .status-badge-small.waiting { background: #fef3c7; color: #d97706; }
        .status-badge-small.active { background: #dcfce7; color: #166534; }
        .status-badge-small.expired { background: #fee2e2; color: #dc2626; }

        .empty-table {
            text-align: center;
            color: #9ca3af;
            padding: 2rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .admin-dashboard-container {
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari backend (passing dari controller)
            const chartLabels = @json($chartLabels ?? []);
            const chartData = @json($chartData ?? []);
            
            if (chartLabels.length > 0 && chartData.length > 0) {
                const ctx = document.getElementById('rentalChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Peminjaman',
                            data: chartData,
                            borderColor: '#667eea',
                            backgroundColor: 'rgba(102, 126, 234, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#667eea',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                backgroundColor: '#1f2937',
                                titleColor: '#fff',
                                bodyColor: '#cbd5e1'
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e7eb'
                                },
                                ticks: {
                                    stepSize: 1
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>