<x-app-layout>
    <x-slot name="header">
        <h2 class="cart-title">🛒 Keranjang Saya</h2>
    </x-slot>

    <div class="cart-container">
        @if(empty($cart))
            <div class="empty-cart-card">
                <div class="empty-cart-icon">🛒</div>
                <h3 class="empty-cart-title">Keranjang Kosong</h3>
                <p class="empty-cart-text">Belum ada produk di keranjang Anda. Yuk mulai belanja!</p>
                <a href="{{ route('products.index') }}" class="empty-cart-btn">
                    🚀 Mulai Belanja
                </a>
            </div>
        @else
            <div class="cart-grid">
                <!-- DAFTAR PRODUK -->
                <div class="cart-items-card">
                    <div class="card-header-cart">
                        <span class="card-icon">📦</span>
                        <h3 class="card-title">Daftar Produk</h3>
                    </div>

                    <div class="cart-items-list">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                            <div class="cart-item">
                                <div class="cart-item-info">
                                    <div class="cart-item-icon">
                                        @if(isset($item['type']) && $item['type'] == 'game') 🎮 @else 💻 @endif
                                    </div>
                                    <div class="cart-item-details">
                                        <div class="cart-item-name">{{ $item['name'] }}</div>
                                        <div class="cart-item-price">Rp {{ number_format($item['price']) }} /hari</div>
                                    </div>
                                </div>
                                
                                <div class="cart-item-actions">
                                    <div class="cart-item-quantity">
                                        <span class="qty-label">Jumlah:</span>
                                        <span class="qty-value">{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="cart-item-subtotal">
                                        <span class="subtotal-label">Subtotal:</span>
                                        <span class="subtotal-value">Rp {{ number_format($subtotal) }}</span>
                                    </div>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="remove-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus item ini?')" class="remove-btn">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- RINGKASAN BELANJA -->
                <div class="summary-card">
                    <div class="summary-header">
                        <span>💰</span>
                        <h4>Ringkasan Belanja</h4>
                    </div>
                    
                    <div class="summary-details">
                        <div class="summary-row">
                            <span>Total Item</span>
                            <span class="summary-value">{{ count($cart) }} produk</span>
                        </div>
                        <div class="summary-row">
                            <span>Total Harga</span>
                            <span class="summary-value total-price">Rp {{ number_format($total) }}</span>
                        </div>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-total">
                        <span>Yang harus dibayar</span>
                        <span class="grand-total">Rp {{ number_format($total) }}</span>
                    </div>
                    
                    <div class="summary-buttons">
                        <a href="{{ route('products.index') }}" class="btn-continue">
                            🛍️ Lanjut Belanja
                        </a>
                        <a href="{{ route('cart.checkout') }}" class="btn-checkout-cart">
                            🚀 Checkout Sekarang
                        </a>
                    </div>
                    
                    <div class="summary-info">
                        <p>✅ Bisa pilih durasi sewa (Jam/Hari) di halaman checkout</p>
                        <p>✅ Masa sewa mulai setelah admin konfirmasi</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* ===== HEADER ===== */
        .cart-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .cart-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .cart-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 2rem;
        }

        /* ===== EMPTY CART ===== */
        .empty-cart-card {
            background: white;
            border-radius: 28px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
        }

        .empty-cart-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
        }

        .empty-cart-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-cart-text {
            color: #6b7280;
            margin-bottom: 1.5rem;
        }

        .empty-cart-btn {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            padding: 0.85rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .empty-cart-btn:hover {
            transform: scale(0.98);
            opacity: 0.9;
        }

        /* ===== CART ITEMS CARD ===== */
        .cart-items-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header-cart {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .card-icon {
            font-size: 1.5rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
            margin: 0;
        }

        /* ===== CART ITEM ===== */
        .cart-items-list {
            padding: 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s;
        }

        .cart-item:hover {
            background: #fafafa;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 2;
        }

        .cart-item-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .cart-item-details {
            display: flex;
            flex-direction: column;
        }

        .cart-item-name {
            font-weight: 700;
            color: #1f2937;
            font-size: 1rem;
        }

        .cart-item-price {
            font-size: 0.8rem;
            color: #6b7280;
            margin-top: 0.2rem;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex: 1;
            justify-content: flex-end;
        }

        .cart-item-quantity {
            text-align: center;
            min-width: 70px;
        }

        .qty-label {
            font-size: 0.7rem;
            color: #6b7280;
            display: block;
        }

        .qty-value {
            font-weight: 700;
            color: #1f2937;
            font-size: 1.1rem;
        }

        .cart-item-subtotal {
            text-align: right;
            min-width: 110px;
        }

        .subtotal-label {
            font-size: 0.7rem;
            color: #6b7280;
            display: block;
        }

        .subtotal-value {
            font-weight: 800;
            color: #3b82f6;
            font-size: 1rem;
        }

        .remove-form {
            margin: 0;
        }

        .remove-btn {
            background: #fee2e2;
            border: none;
            color: #dc2626;
            padding: 0.5rem 1rem;
            border-radius: 40px;
            font-size: 0.75rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .remove-btn:hover {
            background: #fecaca;
            transform: scale(0.95);
        }

        /* ===== SUMMARY CARD ===== */
        .summary-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 100px;
        }

        .summary-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .summary-header span {
            font-size: 1.5rem;
        }

        .summary-header h4 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .summary-details {
            margin-bottom: 1rem;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            color: #4b5563;
            font-size: 0.9rem;
        }

        .summary-value {
            font-weight: 600;
            color: #1f2937;
        }

        .total-price {
            color: #3b82f6;
            font-size: 1rem;
        }

        .summary-divider {
            height: 1px;
            background: linear-gradient(90deg, #e5e7eb, transparent);
            margin: 1rem 0;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .grand-total {
            font-size: 1.4rem;
            font-weight: 800;
            background: linear-gradient(135deg, #059669, #10b981);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .summary-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .btn-continue {
            text-align: center;
            background: #f3f4f6;
            color: #374151;
            padding: 0.85rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-continue:hover {
            background: #e5e7eb;
            transform: scale(0.98);
        }

        .btn-checkout-cart {
            text-align: center;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.85rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.2s;
        }

        .btn-checkout-cart:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        .summary-info {
            background: #f8fafc;
            border-radius: 16px;
            padding: 0.75rem;
            margin-top: 1rem;
        }

        .summary-info p {
            font-size: 0.7rem;
            color: #64748b;
            margin: 0.35rem 0;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 900px) {
            .cart-grid {
                grid-template-columns: 1fr;
            }
            
            .summary-card {
                position: static;
                order: -1;
            }
            
            .cart-container {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .cart-item-actions {
                width: 100%;
                justify-content: space-between;
            }
            
            .cart-item-info {
                width: 100%;
            }
            
            .cart-item-subtotal {
                text-align: left;
            }
        }

        @media (max-width: 640px) {
            .cart-item-actions {
                flex-wrap: wrap;
                gap: 0.75rem;
            }
            
            .remove-btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</x-app-layout>