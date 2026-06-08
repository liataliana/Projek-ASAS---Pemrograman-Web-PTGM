<x-app-layout>
    <x-slot name="header">
        <h2 class="admin-products-title">📦 Admin: Manajemen Produk</h2>
    </x-slot>

    <div class="admin-products-container">
        <div class="admin-products-card">
            <!-- Header dengan Tombol Tambah -->
            <div class="card-header-admin">
                <div class="header-left">
                    <span class="header-icon">🎮</span>
                    <div>
                        <h3>Daftar Produk</h3>
                        <p>Kelola semua produk yang tersedia untuk disewakan</p>
                    </div>
                </div>
                <a href="{{ route('admin.products.create') }}" class="btn-add-product">
                    ➕ Tambah Produk Baru
                </a>
            </div>

            <!-- Search Bar -->
            <div class="search-admin-wrapper">
                <form method="GET" action="{{ route('admin.products.index') }}" class="search-admin-form">
                    <div class="search-admin-box">
                        <span class="search-icon">🔍</span>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari produk..." 
                               class="search-admin-input">
                        <button type="submit" class="search-admin-btn">Cari</button>
                        @if(request('search'))
                            <a href="{{ route('admin.products.index') }}" class="reset-admin-btn">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Produk -->
            @if($products->isEmpty())
                <div class="empty-admin-state">
                    <div class="empty-icon">📭</div>
                    <h4>Belum Ada Produk</h4>
                    <p>Silakan tambah produk baru dengan klik tombol di atas</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="admin-products-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Tipe</th>
                                <th>Link</th>
                                <th>Harga</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr>
                                    <td class="product-name-cell">
                                        <div class="product-name-wrapper">
                                            <span class="product-icon-small">
                                                @if($product->type == 'game') 🎮 @else 📱 @endif
                                            </span>
                                            <span>{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="product-type-badge {{ $product->type == 'game' ? 'badge-game' : 'badge-android' }}">
                                            @if($product->type == 'game') 🎮 Game @else 📱 Android @endif
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ $product->link }}" target="_blank" class="product-link">
                                            🔗 {{ Str::limit($product->link, 30) }}
                                        </a>
                                    </td>
                                    <td class="product-price-cell">
                                        <span class="product-price-admin">Rp {{ number_format($product->price) }}</span>
                                    </td>
                                    <td class="action-buttons-admin">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit-admin">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')" class="btn-delete-admin">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Footer dengan Total Produk -->
                <div class="table-footer">
                    <div class="total-products">
                        <span>📊 Total Produk:</span>
                        <strong>{{ $products->count() }} produk</strong>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* ===== HEADER ===== */
        .admin-products-title {
            font-size: 1.6rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1f2937, #3b82f6);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin: 0;
        }

        /* ===== CONTAINER ===== */
        .admin-products-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        .admin-products-card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* ===== CARD HEADER ===== */
        .card-header-admin {
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

        .btn-add-product {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-add-product:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(0.98);
        }

        /* ===== SEARCH ===== */
        .search-admin-wrapper {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .search-admin-form {
            width: 100%;
        }

        .search-admin-box {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f8fafc;
            border-radius: 60px;
            padding: 0.25rem 0.25rem 0.25rem 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .search-admin-box:focus-within {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-icon {
            font-size: 1rem;
            color: #94a3b8;
        }

        .search-admin-input {
            flex: 1;
            border: none;
            padding: 0.7rem 0;
            background: transparent;
            font-size: 0.9rem;
            outline: none;
        }

        .search-admin-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .search-admin-btn:hover {
            opacity: 0.9;
            transform: scale(0.98);
        }

        .reset-admin-btn {
            background: #e2e8f0;
            color: #475569;
            padding: 0.6rem 1.2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8rem;
            transition: all 0.2s;
        }

        .reset-admin-btn:hover {
            background: #cbd5e1;
        }

        /* ===== TABLE ===== */
        .table-responsive {
            overflow-x: auto;
            padding: 0 1.5rem;
        }

        .admin-products-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-products-table thead tr {
            background: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .admin-products-table th {
            padding: 1rem 0.75rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .admin-products-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .admin-products-table tbody tr:hover {
            background: #fafafa;
        }

        /* ===== PRODUCT NAME ===== */
        .product-name-wrapper {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .product-icon-small {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .product-name-cell {
            font-weight: 600;
            color: #1f2937;
        }

        /* ===== TYPE BADGE ===== */
        .product-type-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .badge-game {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-android {
            background: #dcfce7;
            color: #166534;
        }

        /* ===== LINK ===== */
        .product-link {
            color: #3b82f6;
            text-decoration: none;
            font-size: 0.8rem;
        }

        .product-link:hover {
            text-decoration: underline;
        }

        /* ===== PRICE ===== */
        .product-price-cell {
            font-weight: 700;
        }

        .product-price-admin {
            background: linear-gradient(135deg, #059669, #10b981);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            font-size: 0.9rem;
        }

        /* ===== ACTION BUTTONS ===== */
        .action-buttons-admin {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            justify-content: center;
        }

        .btn-edit-admin {
            background: #fef3c7;
            color: #d97706;
            padding: 0.4rem 0.8rem;
            border-radius: 40px;
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-edit-admin:hover {
            background: #fde68a;
            transform: scale(0.95);
        }

        .btn-delete-admin {
            background: #fee2e2;
            color: #dc2626;
            padding: 0.4rem 0.8rem;
            border-radius: 40px;
            font-size: 0.7rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete-admin:hover {
            background: #fecaca;
            transform: scale(0.95);
        }

        /* ===== TABLE FOOTER ===== */
        .table-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #f0f0f0;
            background: #fafafa;
        }

        .total-products {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .total-products strong {
            color: #1f2937;
        }

        /* ===== EMPTY STATE ===== */
        .empty-admin-state {
            text-align: center;
            padding: 3rem;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .empty-admin-state h4 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .empty-admin-state p {
            color: #6b7280;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .admin-products-container {
                padding: 1rem;
            }
            
            .card-header-admin {
                flex-direction: column;
                text-align: center;
            }
            
            .header-left {
                flex-direction: column;
                text-align: center;
            }
            
            .action-buttons-admin {
                flex-direction: column;
            }
            
            .search-admin-box {
                flex-wrap: wrap;
            }
            
            .search-admin-btn, .reset-admin-btn {
                flex: 1;
                text-align: center;
            }
        }
    </style>
</x-app-layout>