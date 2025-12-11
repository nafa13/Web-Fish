<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Fish Feeder' }}</title>

    {{-- Bootstrap & Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Warna Tema Baru */
            --sidebar-bg: #0f172a;
            /* Slate 900 (Gelap Elegan) */
            --main-bg: #f1f5f9;
            /* Slate 100 (Abu-abu Muda Bersih) */
            --accent-gradient: linear-gradient(90deg, #3b82f6 0%, #06b6d4 100%);
            /* Biru ke Cyan */
            --text-sidebar: #cbd5e1;
            /* Slate 300 */
            --text-sidebar-hover: #ffffff;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--main-bg);
            /* Ubah ke terang agar kartu dashboard pop-up */
            color: #334155;
            overflow-x: hidden;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            padding: 2rem 1.5rem;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.05);
            z-index: 1000;
        }

        /* Logo Brand */
        .brand-logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin-bottom: 3rem;
            padding-left: 0.5rem;
        }

        .brand-logo i {
            font-size: 1.8rem;
            margin-right: 10px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Menu Links */
        .nav-link {
            color: var(--text-sidebar);
            font-weight: 500;
            padding: 12px 20px;
            margin-bottom: 8px;
            border-radius: 12px;
            /* Rounded Pills */
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 1.25rem;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .nav-link:hover {
            color: var(--text-sidebar-hover);
            background-color: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        /* Active State */
        .nav-link.active {
            background: var(--accent-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }

        /* MAIN CONTENT */
        .content {
            margin-left: 280px;
            padding: 2.5rem;
            min-height: 100vh;
        }

        /* Logout Button Area */
        .logout-container {
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .btn-logout:hover {
            background: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Utility */
        .page-header {
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <a href="/dashboard" class="brand-logo">
            <i class="bi bi-tsunami"></i> Fish Feeder
        </a>

        <nav class="d-flex flex-column">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('schedule.index') }}" class="nav-link {{ request()->is('schedule*') ? 'active' : '' }}">
                <i class="bi bi-calendar-range"></i>
                <span>Schedule</span>
            </a>

            <a href="{{ route('fish.status') }}" class="nav-link {{ request()->is('fish-status*') ? 'active' : '' }}">
                <i class="bi bi-activity"></i>
                <span>Fish Status</span>
            </a>

            <a href="#" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                <i class="bi bi-gear-fill"></i>
                <span>Settings</span>
            </a>
        </nav>

        <div class="logout-container">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-logout">
                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- CONTENT AREA --}}
    <main class="content">
        <div class="d-flex justify-content-between align-items-center page-header">
            <div>
                <h4 class="fw-bold mb-0 text-dark">{{ $title ?? 'Overview' }}</h4>
                <p class="text-muted small mb-0">{{ date('l, d F Y') }}</p>
            </div>

            <div class="d-flex align-items-center gap-3 bg-white px-3 py-2 rounded-pill shadow-sm">
                <div class="text-end lh-1">
                    <small class="d-block fw-bold text-dark">{{ auth()->user()->name ?? 'Guest' }}</small>
                    <small class="text-muted" style="font-size: 10px;">Admin</small>
                </div>
                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold"
                    style="width: 35px; height: 35px; border: 2px solid #e2e8f0;">
                    {{ substr(auth()->user()->name ?? 'G', 0, 1) }}
                </div>
            </div>
        </div>

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
