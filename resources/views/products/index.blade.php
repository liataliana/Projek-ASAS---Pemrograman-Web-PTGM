<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">📦 Daftar Produk KlikRental</h2>
    </x-slot>

    <div class="products-container">
        <!-- SEARCH FORM -->
        <div class="search-wrapper">
            <form method="GET" action="{{ route('products.index') }}" class="search-form">
                <div class="search-box">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari produk..." 
                           class="search-input">
                    <button type="submit" class="search-btn">
                        🔍 Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="reset-btn">✖ Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- PRODUCT GRID -->
        <div class="products-grid">
            @forelse($products as $product)
                <div class="product-card">
                    <div class="product-icon">
                        @if($product->type == 'game') 🎮 @else 💻 @endif
                    </div>

                    <div class="product-name">{{ $product->name }}</div>

                    <div class="product-type">
    @if($product->type == 'game') 🎮 GAME @else 📱 ANDROID APP @endif
</div>

<div class="product-price">
    Rp {{ number_format($product->price) }}
    <span class="price-period">/jam & hari</span>
</div>
                    <div class="button-group">
                        <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})" class="cart-btn">
                            🛒 Keranjang
                        </button>
                        <a href="{{ route('products.show', $product) }}" class="detail-btn">
                            📋 Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-message">
                    😞 Produk tidak ditemukan
                </div>
            @endforelse
        </div>
    </div>

    <style>
        /* ===== GLOBAL ===== */
        .page-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .products-container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
            padding: 0 16px;
        }

        /* ===== SEARCH ===== */
        .search-wrapper {
            margin-bottom: 32px;
        }

        .search-form {
            width: 100%;
        }

        .search-box {
            display: flex;
            gap: 12px;
            background: white;
            padding: 8px;
            border-radius: 60px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            padding: 12px 20px;
            border-radius: 60px;
            background: #f3f4f6;
            color: #1f2937;
            font-size: 14px;
        }

        .search-input:focus {
            background: white;
            box-shadow: 0 0 0 2px #3b82f6;
        }

        .search-btn {
            border: none;
            padding: 12px 28px;
            border-radius: 60px;
            background: #2563eb;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-btn:hover {
            background: #1d4ed8;
        }

        .reset-btn {
            padding: 12px 20px;
            border-radius: 60px;
            background: #9ca3af;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s;
        }

        .reset-btn:hover {
            background: #6b7280;
        }

        /* ===== PRODUCT GRID ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 24px;
            width: 100%;
        }

        /* ===== PRODUCT CARD ===== */
        .product-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 24px;
            padding: 20px 16px;
            transition: all 0.3s ease;
            color: white;
        }

        .product-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.12);
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.25);
        }

        .product-icon {
            height: 90px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            margin-bottom: 16px;
        }

        .product-name {
            font-size: 17px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #003db8;
        }

        .product-type {
            font-size: 11px;
            color: #cbd5e1;
            margin-bottom: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .product-price {
            font-size: 20px;
            font-weight: 700;
            color: #60a5fa;
            margin-bottom: 18px;
            text-align: center;
        }

        .price-period {
            font-size: 11px;
            color: #cbd5e1;
            font-weight: normal;
        }

        /* ===== BUTTON GROUP ===== */
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .cart-btn {
            flex: 2;
            border: none;
            padding: 10px 0;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            transition: all 0.2s;
        }

        .cart-btn:hover {
            opacity: 0.9;
            transform: scale(0.97);
        }

        .detail-btn {
            flex: 1;
            text-align: center;
            background: rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.25);
            padding: 10px 0;
            border-radius: 40px;
            text-decoration: none;
            color: white;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .detail-btn:hover {
            background: rgba(0, 0, 0, 0.7);
            transform: scale(0.97);
        }

        .empty-message {
            color: white;
            text-align: center;
            width: 100%;
            padding: 60px;
            grid-column: 1 / -1;
            font-size: 18px;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                gap: 16px;
            }
            .products-container {
                padding: 0 12px;
            }
        }

        @media (max-width: 640px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 12px;
            }
            
            .search-box {
                flex-direction: column;
                border-radius: 20px;
            }
            
            .search-btn, .reset-btn {
                width: 100%;
                text-align: center;
            }

            .product-name {
                font-size: 14px;
            }

            .product-price {
                font-size: 16px;
            }

            .cart-btn, .detail-btn {
                font-size: 10px;
                padding: 8px 0;
            }
        }
    </style>

    <script>
        function addToCart(id, name, price) {
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id, name: name, price: price, quantity: 1 })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Notifikasi floating
                    let notif = document.createElement('div');
                    notif.textContent = `✓ ${name} ditambahkan ke keranjang`;
                    notif.style.cssText = `
                        position: fixed;
                        bottom: 20px;
                        right: 20px;
                        background: #10b981;
                        color: white;
                        padding: 12px 20px;
                        border-radius: 40px;
                        font-size: 14px;
                        font-weight: 600;
                        z-index: 9999;
                        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                        animation: fadeInUp 0.3s ease;
                    `;
                    document.body.appendChild(notif);
                    setTimeout(() => {
                        notif.style.opacity = '0';
                        setTimeout(() => notif.remove(), 300);
                    }, 2000);
                    
                    // Update cart count di navbar
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Animasi notifikasi
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    transform: translateY(20px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</x-app-layout>