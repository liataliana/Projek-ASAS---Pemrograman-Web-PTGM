```php
<nav class="sidebar">

    <!-- BRAND -->
    <div class="brand">

        <i class="bi bi-laptop"></i>

        <span class="brand-text">
            KlikRental
        </span>

    </div>

    <!-- MENU -->
    <div class="menu">

        

        @if(Auth::user()->is_admin)

            <!-- ADMIN DASHBOARD -->
            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active-menu' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active-menu' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Kelola Produk</span>
            </a>

            <a href="{{ route('admin.rentals.index') }}"
               class="{{ request()->routeIs('admin.rentals.*') ? 'active-menu' : '' }}">
                <i class="bi bi-clipboard-data-fill"></i>
                <span>Peminjaman</span>
            </a>

        @else

            <!-- USER DASHBOARD -->
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active-menu' : '' }}">
                <i class="bi bi-house-door-fill"></i>
                <span>Dashboard</span>
            </a>

            <!-- USER MENU -->
            <a href="{{ route('products.index') }}"
               class="{{ request()->routeIs('products.*') ? 'active-menu' : '' }}">
                <i class="bi bi-box-seam-fill"></i>
                <span>Produk</span>
            </a>

            <a href="{{ route('rentals.my') }}"
               class="{{ request()->routeIs('rentals.*') ? 'active-menu' : '' }}">
                <i class="bi bi-journal-check"></i>
                <span>Sewa Saya</span>
            </a>

            <a href="{{ route('cart.view') }}"
               class="{{ request()->routeIs('cart.*') ? 'active-menu' : '' }}">
                <i class="bi bi-cart3"></i>
                <span>Keranjang</span>
                <span id="cart-badge" class="cart-badge">0</span>
            </a>

        @endif

    </div>

</nav>


<style>

/* =========================
   SIDEBAR
========================= */

.sidebar{
    position:fixed;
    top:0;
    left:0;

    width:80px;
    height:100vh;

    background:#0f172a;

    transition:.3s ease;

    z-index:1000;

    overflow:hidden;
}

.sidebar.active{
    width:240px;
}

/* =========================
   BRAND
========================= */

.brand{
    height:70px;

    display:flex;
    align-items:center;
    justify-content:center;

    gap:12px;

    color:white;

    border-bottom:1px solid rgba(255,255,255,.08);
}

.brand i{
    font-size:28px;
}

.brand-text{
    display:none;
    font-size:20px;
    font-weight:700;
}

.sidebar.active .brand-text{
    display:block;
}

/* =========================
   MENU
========================= */

.menu{
    padding:15px 10px;
}

.menu a{
    display:flex;
    align-items:center;

    gap:15px;

    text-decoration:none;

    color:white;

    padding:14px;

    margin-bottom:10px;

    border-radius:12px;

    transition:.3s;
}

.menu a:hover{
    background:#2563eb;
}

.menu a i{
    font-size:22px;
    min-width:30px;
    text-align:center;
}

.menu a span{
    display:none;
}

.sidebar.active .menu a span{
    display:block;
}

/* =========================
   ACTIVE MENU
========================= */

.active-menu{
    background:#2563eb;
    box-shadow:
        0 4px 15px rgba(37,99,235,.35);
}

/* =========================
   CART BADGE
========================= */

.cart-badge{
    margin-left:auto;

    background:#ef4444;

    color:white;

    min-width:22px;
    height:22px;

    border-radius:50%;

    display:flex !important;
    justify-content:center;
    align-items:center;

    font-size:12px;
    font-weight:bold;
}

.sidebar:not(.active) .cart-badge{
    display:none !important;
}

/* =========================
   MOBILE
========================= */

@media(max-width:768px){

    .sidebar{
        left:-240px;
        width:240px;
    }

    .sidebar.active{
        left:0;
    }

    .brand-text{
        display:block;
    }

    .menu a span{
        display:block;
    }

}

</style>

<script>

function updateCartCount() {

    fetch('{{ route("cart.count") }}')

    .then(response => response.json())

    .then(data => {

        const badge =
        document.getElementById('cart-badge');

        if(!badge) return;

        if(data.count > 0){

            badge.innerText =
            data.count;

            badge.style.display =
            'flex';

        }else{

            badge.style.display =
            'none';

        }

    });

}

document.addEventListener(
    'DOMContentLoaded',
    updateCartCount
);

</script>
```
