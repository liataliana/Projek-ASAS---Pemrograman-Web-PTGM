<x-app-layout>
    <x-slot name="header">
        <h2 class="create-product-title">✨ Tambah Produk Baru</h2>
    </x-slot>

    <div class="create-product-container">
        <div class="create-product-card">
            <!-- Header Card -->
            <div class="card-header-create">
                <span class="header-icon">📦</span>
                <div class="header-text">
                    <h3>Form Tambah Produk</h3>
                    <p>Isi data produk dengan lengkap dan benar</p>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('admin.products.store') }}" class="create-form">
                @csrf

                <!-- Nama Produk -->
                <div class="form-group-create">
                    <label class="form-label-create">
                        <span class="label-icon">🏷️</span>
                        Nama Produk
                    </label>
                    <input type="text" 
                           name="name" 
                           required 
                           class="form-input-create" 
                           placeholder="Contoh: Game Petualangan Kode"
                           value="{{ old('name') }}">
                    <p class="input-hint">Masukkan nama produk yang jelas dan mudah diingat</p>
                </div>

                <!-- Tipe Produk -->
                <div class="form-group-create">
                    <label class="form-label-create">
                        <span class="label-icon">📱</span>
                        Tipe Produk
                    </label>
                    <select name="type" required class="form-select-create">
                        <option value="game" {{ old('type') == 'game' ? 'selected' : '' }}>🎮 Game (Itch.io)</option>
                        <option value="android" {{ old('type') == 'android' ? 'selected' : '' }}>📱 Android App (GitHub)</option>
                    </select>
                    <p class="input-hint">Pilih sesuai jenis produk yang akan disewakan</p>
                </div>

                <!-- Link Akses -->
                <div class="form-group-create">
                    <label class="form-label-create">
                        <span class="label-icon">🔗</span>
                        Link Akses
                    </label>
                    <input type="url" 
                           name="link" 
                           required 
                           class="form-input-create" 
                           placeholder="https://itch.io/game/xxx atau https://github.com/xxx"
                           value="{{ old('link') }}">
                    <p class="input-hint">Link download game (Itch.io) atau repository APK (GitHub)</p>
                </div>

                <!-- Harga Sewa -->
                <div class="form-group-create">
                    <label class="form-label-create">
                        <span class="label-icon">💰</span>
                        Harga Sewa
                    </label>
                    <div class="price-input-wrapper">
                        <span class="price-currency">Rp</span>
                        <input type="number" 
                               name="price" 
                               required 
                               class="price-input" 
                               placeholder="0"
                               min="0" 
                               max="999999999"
                               value="{{ old('price') }}">
                    </div>
                    <p class="input-hint">Maksimal harga: <strong>Rp 999.999.999</strong> (Sembilan ratus sembilan puluh sembilan juta)</p>
                </div>

                <!-- Informasi Tambahan -->
                <div class="info-box-create">
                    <div class="info-icon">💡</div>
                    <div class="info-text">
                        <strong>Informasi Penting</strong><br>
                        • Produk yang ditambahkan akan langsung tampil di halaman utama<br>
                        • Pastikan link akses sudah benar dan bisa diakses<br>
                        • Harga sewakan sesuai dengan nilai produk yang ditawarkan
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="form-actions">
                    <a href="{{ route('admin.products.index') }}" class="btn-cancel">
                        ← Batal
                    </a>
                    <button type="submit" class="btn-submit">
                        ✨ Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* ===== HEADER ===== */
        .create-product-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .create-product-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .create-product-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        /* ===== CARD HEADER ===== */
        .card-header-create {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        /* ===== FORM ===== */
        .create-form {
            padding: 1.5rem;
        }

        .form-group-create {
            margin-bottom: 1.5rem;
        }

        .form-label-create {
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

        .form-input-create {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            transition: all 0.2s;
        }

        .form-input-create:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-select-create {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0.85rem 1rem;
            font-size: 0.95rem;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
        }

        .form-select-create:focus {
            outline: none;
            border-color: #667eea;
        }

        .price-input-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 2px solid #e5e7eb;
            border-radius: 16px;
            padding: 0 0.5rem;
            background: white;
            transition: all 0.2s;
        }

        .price-input-wrapper:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .price-currency {
            font-weight: 700;
            color: #6b7280;
            font-size: 1.1rem;
            padding-left: 0.5rem;
        }

        .price-input {
            flex: 1;
            border: none;
            padding: 0.85rem 0.5rem;
            font-size: 0.95rem;
            border-radius: 16px;
        }

        .price-input:focus {
            outline: none;
        }

        .input-hint {
            font-size: 0.7rem;
            color: #6b7280;
            margin-top: 0.4rem;
        }

        .input-hint strong {
            color: #ef4444;
        }

        /* ===== INFO BOX ===== */
        .info-box-create {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #10b981;
        }

        .info-icon {
            font-size: 1.2rem;
        }

        .info-text {
            font-size: 0.75rem;
            color: #166534;
            line-height: 1.5;
        }

        .info-text strong {
            color: #14532d;
        }

        /* ===== BUTTONS ===== */
        .form-actions {
            display: flex;
            gap: 1rem;
        }

        .btn-cancel {
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

        .btn-cancel:hover {
            background: #e5e7eb;
            transform: scale(0.98);
        }

        .btn-submit {
            flex: 2;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            padding: 0.85rem;
            border-radius: 50px;
            border: none;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        /* ===== ERROR VALIDATION ===== */
        .is-invalid {
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.7rem;
            margin-top: 0.25rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .create-product-container {
                padding: 1rem;
            }
            
            .card-header-create {
                padding: 1rem;
            }
            
            .header-icon {
                font-size: 1.8rem;
            }
            
            .header-text h3 {
                font-size: 1.1rem;
            }
            
            .create-form {
                padding: 1rem;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>