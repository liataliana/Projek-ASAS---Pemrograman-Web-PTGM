<x-app-layout>
    <x-slot name="header">
        <h2 class="checkout-title">🛒 Checkout Pesanan</h2>
    </x-slot>

    <div class="checkout-container">
        <div class="checkout-grid">
            <!-- FORM CHECKOUT -->
            <div class="checkout-form-card">
                <div class="card-header">
                    <span class="card-icon">📋</span>
                    <h3 class="card-title">Ringkasan Pesanan</h3>
                </div>

                <!-- DAFTAR PRODUK -->
                <div class="product-list">
                    @foreach($cart as $item)
                        <div class="product-item">
                            <div class="product-info">
                                <div class="product-icon-small">
                                    @if(isset($item['type']) && $item['type'] == 'game') 🎮 @else 💻 @endif
                                </div>
                                <div class="product-details">
                                    <div class="product-name-checkout">{{ $item['name'] }}</div>
                                    <div class="product-meta">{{ $item['quantity'] }} x Rp {{ number_format($item['price']) }}</div>
                                </div>
                            </div>
                            <div class="product-subtotal">
                                Rp {{ number_format($item['price'] * $item['quantity']) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- TOTAL -->
                <div class="total-section">
                    <div class="total-label">Total Pembayaran</div>
                    <div class="total-amount">Rp {{ number_format($total) }}</div>
                </div>

                <!-- FORM DURASI -->
                <form method="POST" action="{{ route('checkout.payment') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label class="form-label">
                            <span>⏱️ Durasi Sewa</span>
                        </label>
                        <div class="duration-input-group">
                            <input type="number" 
                                   name="duration_value" 
                                   required 
                                   class="duration-input" 
                                   placeholder="Masukkan angka"
                                   min="1">
                            <select name="duration_unit" required class="duration-select">
                                <option value="hours">Jam</option>
                                <option value="days">Hari</option>
                            </select>
                        </div>
                    </div>

                    <!-- INFO BOX -->
                    <div class="info-box">
                        <div class="info-icon">💡</div>
                        <div class="info-text">
                            <strong>Informasi Penting</strong><br>
                            Setelah checkout, admin akan mengkonfirmasi pesanan Anda.<br>
                            Masa sewa dimulai <strong>SETELAH</strong> dikonfirmasi oleh admin.
                        </div>
                    </div>

                    <!-- BUTTONS -->
                    <div class="action-buttons">
                        <a href="{{ route('cart.view') }}" class="btn-back">
                            ← Kembali ke Keranjang
                        </a>
                        <button type="submit" class="btn-checkout">
                            🚀 Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>

            <!-- SIDE INFO -->
            <div class="info-card">
                <div class="info-header">
                    <span>📌</span>
                    <h4>Informasi Sewa</h4>
                </div>
                <div class="info-content">
                    <p>✅ Bisa pilih durasi <strong>Jam</strong> atau <strong>Hari</strong></p>
                    <p>✅ Masa aktif mulai setelah admin konfirmasi</p>
                    <p>✅ Anda akan mendapat link akses setelah aktif</p>
                    <p>✅ Link akan hilang setelah masa sewa habis</p>
                </div>
                <div class="info-footer">
                    <span>🎮</span>
                    <span>📱</span>
                    <span>💻</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ===== HEADER ===== */
        .checkout-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .checkout-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 2rem;
        }

        /* ===== FORM CARD ===== */
        .checkout-form-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-icon {
            font-size: 1.8rem;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        /* ===== PRODUCT LIST ===== */
        .product-list {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-item:last-child {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-icon-small {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .product-details {
            display: flex;
            flex-direction: column;
        }

        .product-name-checkout {
            font-weight: 700;
            color: #1f2937;
            font-size: 1rem;
        }

        .product-meta {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.2rem;
        }

        .product-subtotal {
            font-weight: 700;
            color: #3b82f6;
            font-size: 1rem;
        }

        /* ===== TOTAL ===== */
        .total-section {
            background: #f8fafc;
            margin: 0 1.5rem 1.5rem 1.5rem;
            padding: 1.25rem;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total-label {
            font-size: 1rem;
            font-weight: 600;
            color: #475569;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        /* ===== FORM ===== */
        .form-group {
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }

        .duration-input-group {
            display: flex;
            gap: 1rem;
        }

        .duration-input {
            flex: 1;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 1rem;
            transition: all 0.2s;
            background: white;
        }

        .duration-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .duration-select {
            flex: 1;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 1rem;
            background: white;
            cursor: pointer;
        }

        /* ===== INFO BOX ===== */
        .info-box {
            background: linear-gradient(135deg, #fef3c7, #fffbeb);
            border-radius: 20px;
            padding: 1rem;
            margin: 0 1.5rem 1.5rem 1.5rem;
            display: flex;
            gap: 1rem;
            border-left: 4px solid #f59e0b;
        }

        .info-icon {
            font-size: 1.5rem;
        }

        .info-text {
            font-size: 0.8rem;
            color: #92400e;
            line-height: 1.4;
        }

        .info-text strong {
            color: #b45309;
        }

        /* ===== BUTTONS ===== */
        .action-buttons {
            display: flex;
            gap: 1rem;
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        .btn-back {
            flex: 1;
            text-align: center;
            background: #f3f4f6;
            color: #374151;
            padding: 0.85rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #e5e7eb;
            transform: scale(0.98);
        }

        .btn-checkout {
            flex: 2;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.85rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-checkout:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        /* ===== SIDE INFO CARD ===== */
        .info-card {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 28px;
            padding: 1.5rem;
            color: white;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .info-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .info-header h4 {
            font-size: 1.2rem;
            margin: 0;
        }

        .info-content {
            margin-bottom: 1.5rem;
        }

        .info-content p {
            margin: 0.75rem 0;
            font-size: 0.85rem;
            color: #cbd5e1;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-content p::before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
        }

        .info-footer {
            display: flex;
            gap: 1rem;
            justify-content: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }
            
            .info-card {
                position: static;
                order: -1;
            }
            
            .checkout-container {
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .product-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .product-subtotal {
                align-self: flex-end;
            }
            
            .duration-input-group {
                flex-direction: column;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>