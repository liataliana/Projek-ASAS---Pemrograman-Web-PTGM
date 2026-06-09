<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">📦 Detail {{ $product->type == 'game' ? 'Game' : 'Aplikasi Android' }}</h2>
    </x-slot>

    <div class="products-container">
        <!-- Tombol Kembali -->
        <div style="margin-bottom: 24px;">
            <a href="{{ route('products.index') }}" class="back-button">
                ← Kembali ke Daftar Produk
            </a>
        </div>

        <!-- Detail Card -->
        <div class="detail-card">
            <!-- Icon & Nama Produk -->
            <div class="detail-icon">
                @if($product->type == 'game') 🎮 @else 📱 @endif
            </div>
            
            <h1 class="detail-name">{{ $product->name }}</h1>
            
            <div class="detail-badge">
                @if($product->type == 'game') 
                    🎮 GAME 
                @else 
                    📱 ANDROID APP 
                @endif
            </div>
            
            <!-- Spesifikasi -->
            <div class="detail-specs">
                <div class="spec-item">
    <span class="spec-label">📌 Tipe Produk</span>
    <span class="spec-value">{{ $product->type == 'game' ? 'Game Online (Itch.io)' : 'Aplikasi Android (APK)' }}</span>
</div>
                <div class="spec-item">
                    <span class="spec-label">💰 Harga Sewa</span>
                    <span class="spec-value">Rp {{ number_format($product->price) }} <span style="font-size: 12px;">/jam & hari</span></span>
                </div>
                
                <div class="spec-item">
                    <span class="spec-label">✅ Status</span>
                    <span class="spec-value" style="color: #10b981; font-weight: 700;">Tersedia</span>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="detail-description">
                <p>
                    @if($product->type == 'game')
                        🎮 <strong>Game Online</strong><br>
                        Game edukasi seru yang bisa dimainkan langsung di browser via Itch.io. 
                        Cocok untuk belajar sambil bermain. Sewa sesuai durasi yang Anda pilih.
                    @else
                        📱 <strong>Aplikasi Android</strong><br>
                        Aplikasi Android siap pakai, bisa di-download dan diinstall di perangkat Android Anda.
                        Cocok untuk kebutuhan belajar dan produktivitas.
                    @endif
                </p>
            </div>

            <!-- Tombol Aksi -->
            <div class="detail-actions">
                <button onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})" class="cart-btn-detail">
                    🛒 Tambah ke Keranjang
                </button>
                <a href="{{ route('rentals.create', $product) }}" class="rent-btn-detail">
                    🚀 Sewa Sekarang
                </a>
            </div>
        </div>
    </div>

    <style>
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .products-container {
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
            padding: 0 16px;
        }

        /* BACK BUTTON */
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            padding: 8px 18px;
            border-radius: 40px;
            color: white;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .back-button:hover {
            background: rgba(0, 0, 0, 0.8);
            transform: translateX(-2px);
        }

        /* DETAIL CARD */
        .detail-card {
            background: white;
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.15);
        }

        .detail-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 52px;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .detail-name {
            font-size: 28px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .detail-badge {
            text-align: center;
            background: #e0e7ff;
            color: #4338ca;
            padding: 6px 16px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            display: inline-block;
            width: auto;
            margin: 0 auto 24px;
        }

        /* SPECS */
        .detail-specs {
            background: #f8fafc;
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .spec-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .spec-item:last-child {
            border-bottom: none;
        }

        .spec-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
        }

        .spec-value {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .detail-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .detail-link:hover {
            text-decoration: underline;
        }

        /* DESCRIPTION */
        .detail-description {
            background: #f1f5f9;
            border-radius: 16px;
            padding: 18px;
            margin-bottom: 28px;
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
            border-left: 4px solid #3b82f6;
        }

        /* BUTTON ACTIONS */
        .detail-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .cart-btn-detail {
            flex: 1;
            border: none;
            padding: 14px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            background: #f1f5f9;
            color: #1e293b;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .cart-btn-detail:hover {
            background: #e2e8f0;
            transform: scale(0.98);
        }

        .rent-btn-detail {
            flex: 1;
            text-align: center;
            text-decoration: none;
            padding: 14px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 700;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            transition: all 0.2s;
        }

        .rent-btn-detail:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        @media (max-width: 640px) {
            .products-container {
                padding: 0 12px;
            }
            .detail-card {
                padding: 20px;
            }
            .detail-name {
                font-size: 22px;
            }
            .detail-actions {
                flex-direction: column;
            }
            .spec-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }
        }
    </style>

    <script>
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('cart-badge');
                if (badge) {
                    if (data.count > 0) {
                        badge.innerText = data.count;
                        badge.style.display = 'inline-block';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
    }

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
                
                // Update cart count
                updateCartCount();
            }
        })
        .catch(error => console.error('Error:', error));
    }

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