<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Fish Feeder' }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0b1120;       /* Hitam Kebiruan Gelap */
            --sidebar-bg: #151e32;    /* Navy Gelap */
            --card-bg: #1e293b;       /* Abu-abu Kebiruan */
            --accent: #3b82f6;        /* Biru Neon */
            --accent-hover: #2563eb;  /* Biru lebih gelap saat hover */
            --text-main: #f8fafc;     /* Putih Terang */
            --text-muted: #94a3b8;    /* Abu-abu Teks */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
        }

        /* SIDEBAR STYLING */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            padding-top: 30px;
            transition: all 0.3s;
        }

        .sidebar h4 {
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2rem;
        }

        .sidebar a {
            color: var(--text-muted);
            text-decoration: none;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            font-size: 15px;
            transition: 0.3s;
            border-left: 3px solid transparent;
        }

        .sidebar a i {
            margin-right: 12px;
            font-size: 1.2rem;
        }

        .sidebar a:hover, .sidebar a.active {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
            border-left: 3px solid var(--accent);
        }

        /* CONTENT AREA */
        .content {
            margin-left: 260px;
            padding: 40px;
        }

        /* GLOBAL CARD STYLE */
        .card {
            background-color: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            color: white;
        }
        
        h5 { color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; }
        h2 { font-weight: 600; }
        hr { border-color: rgba(255, 255, 255, 0.1); }

        /* BUTTON STYLE */
        .btn-primary {
            background-color: var(--accent);
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: var(--accent-hover);
        }
        
        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            transition: 0.3s;
        }
        .logout-btn:hover {
            background: #ef4444;
            color: white;
        }
    </style>
</head>

<body>

    <div class="sidebar">
        <h4 class="text-center">🐟 Fish Feeder</h4>

        <div class="mt-4">
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Dashboard
            </a>
            <a href="#"><i class="bi bi-alarm"></i> Schedule</a>
            <a href="#"><i class="bi bi-graph-up"></i> Fish Status</a>
            <a href="#"><i class="bi bi-sliders"></i> Settings</a>
        </div>

        <div class="px-4" style="position: absolute; bottom: 30px; width: 100%;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn logout-btn w-100 py-2">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">{{ $pageTitle ?? 'Overview' }}</h3>
            <span class="badge bg-secondary px-3 py-2 rounded-pill">{{ date('d M Y') }}</span>
        </div>
        
        @yield('content')
    </div>

</body>
</html>