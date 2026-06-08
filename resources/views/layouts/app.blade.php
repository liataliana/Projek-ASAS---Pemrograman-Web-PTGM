<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>KlikRental</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            overflow-x: hidden;
            background: linear-gradient(to right,
                    #0f172a 0%,
                    #1e3a8a 50%,
                    #2563eb 100%);
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 80px;
            height: 100vh;
            background: #0f172a;
            transition: width 0.3s ease;
            z-index: 1000;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .sidebar.active {
            width: 240px;
        }

        .brand {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
            color: white;
        }

        .brand i {
            font-size: 28px;
        }

        .brand-text {
            display: none;
            font-weight: 700;
            font-size: 20px;
        }

        .sidebar.active .brand-text {
            display: block;
        }

        .menu {
            padding: 20px 10px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 10px;
            transition: .3s;
            white-space: nowrap;
        }

        .menu a:hover {
            background: #2563eb;
        }

        .menu a span {
            display: none;
        }

        .sidebar.active .menu a span {
            display: block;
        }

        .menu a i {
            font-size: 22px;
            min-width: 30px;
            text-align: center;
        }

        /* NAVBAR */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 80px;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, .12);
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
            transition: left 0.3s ease;
            z-index: 999;
        }

        .sidebar.active~.content-area .top-navbar {
            left: 240px;
        }

        /* CONTENT AREA - PERBAIKAN UTAMA */
        .content-area {
            margin-left: 80px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            width: calc(100% - 80px);
            overflow-x: hidden;
        }

        .sidebar.active~.content-area {
            margin-left: 240px;
            width: calc(100% - 240px);
        }

        /* PAGE CONTENT */
        .page-content {
            margin-top: 90px;
            padding: 20px 25px;
            width: 100%;
            overflow-x: hidden;
        }

        /* CONTENT CARD - TIDAK TEMBUS/TROPOS */
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-radius: 24px;
            padding: 30px;
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        }

        /* Scroll hanya ke bawah, tidak horizontal */
        .content-card::-webkit-scrollbar {
            height: 0;
            width: 8px;
        }

        .content-card::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .content-card::-webkit-scrollbar-thumb {
            background: #2563eb;
            border-radius: 10px;
        }

        /* RESPONSIVE UNTUK SIDEBAR BUKA/TUTUP */
        @media (max-width: 768px) {
            .sidebar {
                left: -240px;
                width: 240px;
                transition: left 0.3s ease;
            }

            .sidebar.active {
                left: 0;
            }

            .content-area {
                margin-left: 0 !important;
                width: 100% !important;
            }

            .top-navbar {
                left: 0 !important;
                right: 0;
            }

            .page-content {
                padding: 15px;
            }

            .content-card {
                padding: 20px;
            }
        }

        /* Untuk layar sangat kecil */
        @media (max-width: 480px) {
            .content-card {
                padding: 15px;
                border-radius: 16px;
            }
            
            .page-content {
                padding: 10px;
            }
            
            .top-navbar {
                padding: 0 15px;
            }
        }

        /* Navbar left styling */
        .navbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .date-box {
            color: white;
            font-weight: 600;
        }

        /* Dropdown styling */
        .dropdown .btn-light {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        .dropdown .btn-light:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>

</head>

<body>

    <div class="main-layout">

        @include('layouts.navigation')

        <div class="content-area">

            <div class="top-navbar">

                <div class="navbar-left">

                    <button id="toggleSidebar" class="toggle-btn">

                        <i class="bi bi-list"></i>

                    </button>

                    <div class="date-box">

                        <i class="bi bi-calendar3"></i>

                        {{ now()->format('d F Y') }}

                    </div>

                </div>

                <div class="dropdown">

                    <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">

                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->name }}

                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                        
                        

                        <li>

                            <form method="POST" action="{{ route('logout') }}">

                                @csrf

                                <button class="dropdown-item text-danger">

                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </div>

            </div>

            <div class="page-content">

                <div class="content-card shadow-lg">

                    @isset($header)
                        {{ $header }}
                    @endisset

                    {{ $slot }}

                </div>

            </div>

        </div>

    </div>

    <script>

        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            
            // Optional: simpan state ke localStorage
            if (sidebar.classList.contains('active')) {
                localStorage.setItem('sidebarActive', 'true');
            } else {
                localStorage.setItem('sidebarActive', 'false');
            }
        });

        // Load sidebar state dari localStorage
        if (localStorage.getItem('sidebarActive') === 'true') {
            sidebar.classList.add('active');
        }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>