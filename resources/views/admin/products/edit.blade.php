<x-app-layout>
    <x-slot name="header">
        <h2 class="edit-product-title">✏️ Edit Produk</h2>
    </x-slot>

    <div class="edit-product-container">
        <div class="edit-product-card">
            <!-- Header Card -->
            <div class="card-header-edit">
                <span class="header-icon">📝</span>
                <div class="header-text">
                    <h3>Form Edit Produk</h3>
                    <p>Ubah data produk yang sudah ada</p>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('admin.products.update', $product) }}" class="edit-form">
                @csrf
                @method('PUT')

                <!-- Nama Produk -->
                <div class="form-group-edit">
                    <label class="form-label-edit">
                        <span class="label-icon">🏷️</span>
                        Nama Produk
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required 
                           class="form-input-edit" 
                           placeholder="Contoh: Game Petualangan Kode">
                    <p class="input-hint">Masukkan nama produk yang jelas dan mudah diingat</p>
                </div>

                <!-- Tipe Produk -->
                <div class="form-group-edit">
                    <label class="form-label-edit">
                        <span class="label-icon">📱</span>
                        Tipe Produk
                    </label>
                    <select name="type" required class="form-select-edit">
                        <option value="game" {{ $product->type == 'game' ? 'selected' : '' }}>🎮 Game (Itch.io)</option>
                        <option value="android" {{ $product->type == 'android' ? 'selected' : '' }}>📱 Android App (GitHub)</option>
                    </select>
                    <p class="input-hint">Pilih sesuai jenis produk yang disewakan</p>
                </div>

                <!-- Link Akses -->
                <div class="form-group-edit">
                    <label class="form-label-edit">
                        <span class="label-icon">🔗</span>
                        Link Akses
                    </label>
                    <input type="url" 
                           name="link" 
                           value="{{ old('link', $product->link) }}" 
                           required 
                           class="form-input-edit" 
                           placeholder="https://itch.io/game/xxx atau https://github.com/xxx">
                    <p class="input-hint">Link download game (Itch.io) atau repository APK (GitHub)</p>
                </div>

                <!-- Harga Sewa -->
                <div class="form-group-edit">
                    <label class="form-label-edit">
                        <span class="label-icon">💰</span>
                        Harga Sewa
                    </label>
                    <div class="price-input-wrapper-edit">
                        <span class="price-currency">Rp</span>
                        <input type="number" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               required 
                               class="price-input-edit" 
                               placeholder="0"
                               min="0" 
                               max="999999999">
                    </div>
                    <p class="input-hint">Maksimal harga: <strong>Rp 999.999.999</strong> (Sembilan ratus sembilan puluh sembilan juta)</p>
                </div>

                <!-- Informasi Tambahan -->
                <div class="info-box-edit">
                    <div class="info-icon">💡</div>
                    <div class="info-text">
                        <strong>Informasi Penting</strong><br>
                        • Perubahan akan langsung tampil di halaman utama<br>
                        • Pastikan link akses sudah benar dan bisa diakses<br>
                        • Harga sewakan sesuai dengan nilai produk yang ditawarkan
                    </div>
                </div>

                <!-- Current Product Info -->
                <div class="current-info-box">
                    <div class="current-info-icon">📌</div>
                    <div class="current-info-text">
                        <strong>Produk Saat Ini</strong><br>
                        Tipe: <strong>{{ $product->type == 'game' ? '🎮 Game' : '📱 Android App' }}</strong><br>
                        Link: <a href="{{ $product->link }}" target="_blank" style="color: #3b82f6;">{{ Str::limit($product->link, 40) }}</a>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="form-actions-edit">
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel-edit">
                        ← Batal
                    </a>
                    <button type="submit" class="btn-submit-edit">
                        💾 Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ===== HEADER ===== */
        .edit-product-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #f59e0b);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .edit-product-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .edit-product-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* ===== CARD HEADER ===== */
        .card-header-edit {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            font-size: 2.5rem;
        }

        .header-text h3 {
            font-size: 1.3rem;
            font-weight: 700;
            color: white;
            margin: 0 0 0.25rem 0;
        }

        .header-text p {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
        }

        /* ===== FORM ===== */
        .edit-form {
            padding: 1.5rem;
        }

        .form-group-edit {
            margin-bottom: 1.5rem;
        }

        .form-label-edit {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .label-icon {
            font-size: 1.1rem;
        }

        .form-input-edit {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-input-edit:focus {
            outline: none;
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .form-select-edit {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .form-select-edit:focus {
            outline: none;
            border-color: #f59e0b;
        }

        .price-input-wrapper-edit {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0 0.5rem;
            background: white;
            transition: all 0.2s;
        }

        .price-input-wrapper-edit:focus-within {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        }

        .price-currency {
            font-weight: 700;
            color: #6b7280;
            font-size: 1.1rem;
            padding-left: 0.5rem;
        }

        .price-input-edit {
            flex: 1;
            border: none;
            padding: 0.85rem 0.5rem;
            font-size: 0.95rem;
            border-radius: 16px;
        }

        .price-input-edit:focus {
            outline: none;
        }

        .input-hint {
            font-size: 0.7rem;
            color: #6b7280;
            margin-top: 0.4rem;
        }

        .input-hint strong {
            color: #f59e0b;
        }

        /* ===== INFO BOX ===== */
        .info-box-edit {
            background: linear-gradient(135deg, #fef3c7, #fffbeb);
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1rem;
            border-left: 4px solid #f59e0b;
        }

        .info-icon {
            font-size: 1.2rem;
        }

        .info-text {
            font-size: 0.75rem;
            color: #92400e;
            line-height: 1.5;
        }

        .info-text strong {
            color: #b45309;
        }

        /* ===== CURRENT INFO BOX ===== */
        .current-info-box {
            background: #f0fdf4;
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #10b981;
        }

        .current-info-icon {
            font-size: 1.2rem;
        }

        .current-info-text {
            font-size: 0.8rem;
            color: #166534;
            line-height: 1.5;
        }

        .current-info-text strong {
            color: #14532d;
        }

        .current-info-text a {
            text-decoration: none;
            word-break: break-all;
        }

        .current-info-text a:hover {
            text-decoration: underline;
        }

        /* ===== BUTTONS ===== */
        .form-actions-edit {
            display: flex;
            gap: 1rem;
        }

        .btn-cancel-edit {
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

        .btn-cancel-edit:hover {
            background: #e5e7eb;
            transform: scale(0.98);
        }

        .btn-submit-edit {
            flex: 2;
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 0.85rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit-edit:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .edit-product-container {
                padding: 1rem;
            }
            
            .card-header-edit {
                padding: 1rem;
            }
            
            .header-icon {
                font-size: 1.8rem;
            }
            
            .header-text h3 {
                font-size: 1.1rem;
            }
            
            .edit-form {
                padding: 1rem;
            }
            
            .form-actions-edit {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>