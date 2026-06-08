<x-app-layout>
    <x-slot name="header">
        <h2 class="payment-title">💳 Pembayaran</h2>
    </x-slot>

    <div class="payment-container">
        <div class="payment-grid">
            <!-- FORM PEMBAYARAN -->
            <div class="payment-card">
                <div class="payment-header">
                    <span class="payment-icon">💰</span>
                    <h3 class="payment-header-title">Total Pembayaran</h3>
                </div>

                <!-- TOTAL HARGA -->
                <div class="total-amount-wrapper">
                    <span class="total-amount-label">Yang harus dibayar:</span>
                    <div class="total-amount-big">Rp {{ number_format($total) }}</div>
                </div>

                <!-- RINGKASAN PESANAN -->
                <div class="order-summary">
                    <div class="summary-header">
                        <span>📋</span>
                        <h4>Ringkasan Pesanan</h4>
                    </div>
                    
                    <div class="summary-items">
                        @foreach($cart as $item)
                            <div class="summary-item">
                                <div class="summary-item-info">
                                    <div class="summary-item-name">{{ $item['name'] }}</div>
                                    <div class="summary-item-qty">{{ $item['quantity'] }}x</div>
                                </div>
                                <div class="summary-item-price">
                                    Rp {{ number_format($item['price'] * $item['quantity']) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span class="summary-total-amount">Rp {{ number_format($total) }}</span>
                    </div>
                </div>

                <!-- METODE PEMBAYARAN (BISA DIPILIH) -->
                <form method="POST" action="{{ route('checkout.process') }}" id="paymentForm">
                    @csrf
                    
                    <div class="payment-methods">
                        <div class="methods-header">
                            <span>🏦</span>
                            <h4>Pilih Metode Pembayaran</h4>
                        </div>
                        
                        <div class="methods-grid">
                            <div class="method-card" data-method="credit_card">
                                <div class="method-icon">💳</div>
                                <div class="method-name">Kartu Kredit</div>
                                <div class="method-desc">Visa / Mastercard</div>
                            </div>
                            <div class="method-card" data-method="bank_transfer">
                                <div class="method-icon">🏦</div>
                                <div class="method-name">Transfer Bank</div>
                                <div class="method-desc">BCA / Mandiri / BNI</div>
                            </div>
                            <div class="method-card" data-method="ewallet">
                                <div class="method-icon">📱</div>
                                <div class="method-name">E-Wallet</div>
                                <div class="method-desc">OVO / GoPay / Dana</div>
                            </div>
                        </div>
                        
                        <!-- Input hidden untuk menyimpan metode pembayaran yang dipilih -->
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                    </div>

                    <!-- INFO PEMBAYARAN -->
                    <div class="payment-info" id="paymentInfo">
                        <div class="payment-info-icon">📌</div>
                        <div class="payment-info-text">
                            <strong id="infoTitle">Pilih metode pembayaran</strong><br>
                            <span id="infoDesc">Klik salah satu metode pembayaran di atas untuk melanjutkan</span>
                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="payment-actions">
                        <a href="{{ route('cart.view') }}" class="btn-back-payment">
                            ← Kembali ke Keranjang
                        </a>
                        <button type="submit" class="btn-pay" id="payButton" disabled>
                            💳 Bayar Sekarang
                        </button>
                    </div>
                </form>
            </div>

            <!-- SIDE INFO -->
            <div class="info-side-card">
                <div class="info-side-header">
                    <span>📌</span>
                    <h4>Info Penting</h4>
                </div>
                <div class="info-side-content">
                    <div class="info-side-item">
                        <span>🕐</span>
                        <p>Pembayaran akan diproses secara instan</p>
                    </div>
                    <div class="info-side-item">
                        <span>✅</span>
                        <p>Setelah bayar, admin akan konfirmasi pesanan</p>
                    </div>
                    <div class="info-side-item">
                        <span>⏰</span>
                        <p>Masa sewa mulai setelah dikonfirmasi admin</p>
                    </div>
                    <div class="info-side-item">
                        <span>🔗</span>
                        <p>Link akses muncul saat status "Aktif"</p>
                    </div>
                </div>
                <div class="info-side-footer">
                    🎮 &nbsp; 📱 &nbsp; 💻
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #10b981);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        .payment-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 2rem;
        }

        .payment-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .payment-header {
            background: linear-gradient(135deg, #10b981, #059669);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .payment-icon {
            font-size: 1.8rem;
        }

        .payment-header-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        .total-amount-wrapper {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            margin: 1.5rem 1.5rem 0 1.5rem;
            padding: 1.5rem;
            border-radius: 20px;
            text-align: center;
        }

        .total-amount-label {
            font-size: 0.85rem;
            color: #166534;
            display: block;
            margin-bottom: 0.5rem;
        }

        .total-amount-big {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #059669, #10b981);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .order-summary {
            margin: 1.5rem;
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
        }

        .summary-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1rem;
        }

        .summary-header span {
            font-size: 1.2rem;
        }

        .summary-header h4 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }

        .summary-items {
            margin-bottom: 1rem;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .summary-item-info {
            display: flex;
            gap: 1rem;
            align-items: baseline;
        }

        .summary-item-name {
            font-weight: 500;
            color: #1e293b;
        }

        .summary-item-qty {
            font-size: 0.75rem;
            color: #64748b;
        }

        .summary-item-price {
            font-weight: 600;
            color: #3b82f6;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            margin-top: 0.5rem;
            border-top: 2px dashed #cbd5e1;
            font-weight: 700;
            color: #1e293b;
        }

        .summary-total-amount {
            font-size: 1.2rem;
            color: #059669;
        }

        .payment-methods {
            margin: 0 1.5rem 1.5rem 1.5rem;
        }

        .methods-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .methods-header span {
            font-size: 1.2rem;
        }

        .methods-header h4 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
        }

        .methods-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .method-card {
            background: white;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.75rem;
            text-align: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .method-card.active {
            border-color: #10b981;
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
        }

        .method-card:hover {
            border-color: #10b981;
            transform: translateY(-2px);
        }

        .method-icon {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .method-name {
            font-size: 0.7rem;
            font-weight: 600;
            color: #1f2937;
        }

        .method-desc {
            font-size: 0.6rem;
            color: #6b7280;
        }

        .payment-info {
            background: linear-gradient(135deg, #fef3c7, #fffbeb);
            margin: 0 1.5rem 1.5rem 1.5rem;
            padding: 1rem;
            border-radius: 16px;
            display: flex;
            gap: 0.75rem;
            border-left: 4px solid #f59e0b;
        }

        .payment-info-icon {
            font-size: 1.2rem;
        }

        .payment-info-text {
            font-size: 0.75rem;
            color: #92400e;
            line-height: 1.4;
        }

        .payment-info-text strong {
            color: #b45309;
        }

        .payment-actions {
            display: flex;
            gap: 1rem;
            padding: 0 1.5rem 1.5rem 1.5rem;
        }

        .btn-back-payment {
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

        .btn-back-payment:hover {
            background: #e5e7eb;
            transform: scale(0.98);
        }

        .btn-pay {
            flex: 2;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.85rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-pay:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        .btn-pay:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .info-side-card {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-radius: 28px;
            padding: 1.5rem;
            color: white;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .info-side-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            font-size: 1.3rem;
        }

        .info-side-header h4 {
            margin: 0;
            font-size: 1.1rem;
        }

        .info-side-content {
            margin-bottom: 1.5rem;
        }

        .info-side-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 1rem 0;
            font-size: 0.8rem;
            color: #cbd5e1;
        }

        .info-side-item span {
            font-size: 1.1rem;
        }

        .info-side-item p {
            margin: 0;
        }

        .info-side-footer {
            text-align: center;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 1.2rem;
        }

        @media (max-width: 900px) {
            .payment-grid {
                grid-template-columns: 1fr;
            }
            .info-side-card {
                position: static;
                order: -1;
            }
            .payment-container {
                padding: 1rem;
            }
        }

        @media (max-width: 640px) {
            .methods-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
            }
            .payment-actions {
                flex-direction: column;
            }
            .total-amount-big {
                font-size: 1.8rem;
            }
        }
    </style>

    <script>
        // Data metode pembayaran
        const paymentMethods = {
            credit_card: {
                title: '💳 Pembayaran dengan Kartu Kredit',
                desc: 'Silakan masukkan detail kartu kredit Anda. Pembayaran akan diproses secara instan.'
            },
            bank_transfer: {
                title: '🏦 Pembayaran via Transfer Bank',
                desc: 'Transfer ke rekening BCA 1234567890 a.n. KlikRental. Upload bukti transfer setelah ini.'
            },
            ewallet: {
                title: '📱 Pembayaran via E-Wallet',
                desc: 'Scan QR Code atau masukkan nomor virtual account. Pembayaran akan diproses otomatis.'
            }
        };

        // Ambil elemen
        const methodCards = document.querySelectorAll('.method-card');
        const paymentMethodInput = document.getElementById('payment_method');
        const payButton = document.getElementById('payButton');
        const infoTitle = document.getElementById('infoTitle');
        const infoDesc = document.getElementById('infoDesc');

        // Event listener untuk setiap metode pembayaran
        methodCards.forEach(card => {
            card.addEventListener('click', function() {
                // Hapus class active dari semua card
                methodCards.forEach(c => c.classList.remove('active'));
                
                // Tambah class active ke card yang diklik
                this.classList.add('active');
                
                // Ambil value metode
                const method = this.dataset.method;
                paymentMethodInput.value = method;
                
                // Update info box
                infoTitle.innerHTML = paymentMethods[method].title;
                infoDesc.innerHTML = paymentMethods[method].desc;
                
                // Enable tombol bayar
                payButton.disabled = false;
            });
        });
    </script>
</x-app-layout>