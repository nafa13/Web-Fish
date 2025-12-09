<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fish Feeder</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-dark: #0b1120;       /* Hitam Kebiruan Gelap */
            --card-bg: #1e293b;       /* Abu-abu Kebiruan */
            --accent: #3b82f6;        /* Biru Neon */
            --accent-hover: #2563eb;  /* Biru lebih gelap saat hover */
            --text-main: #f8fafc;     /* Putih Terang */
            --text-muted: #94a3b8;    /* Abu-abu Teks */
            --input-bg: #0f172a;      /* Background Input */
            --input-border: #334155;  /* Border Input */
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            position: relative;
        }

        /* Background Glow Effect (Lebih halus) */
        .glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, rgba(11,17,32,0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            pointer-events: none;
        }

        /* Card Login yang Lebih Compact */
        .login-card {
            background-color: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            width: 100%;
            max-width: 360px; /* Diperkecil dari 420px */
            padding: 2rem;    /* Padding dikurangi */
            border-radius: 16px;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 10;
        }

        .brand-logo {
            width: 50px; /* Ukuran logo diperkecil sedikit */
            height: 50px;
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.5rem;
            margin: 0 auto 1.2rem;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        h4 { font-weight: 600; color: white; margin-bottom: 0.3rem; font-size: 1.3rem; }
        p.subtitle { color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem; }

        /* Form Styling */
        .form-control {
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            color: white;
            padding: 10px 14px; /* Padding input lebih compact */
            border-radius: 8px;
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            background-color: var(--input-bg);
            border-color: var(--accent);
            color: white;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .input-group-text {
            border-color: var(--input-border) !important;
            background: var(--input-bg) !important;
            color: var(--text-muted);
            border-right: none;
        }

        .form-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            margin-bottom: 6px;
        }

        .btn-primary {
            background-color: var(--accent);
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: 0 8px 15px -4px rgba(59, 130, 246, 0.4);
        }

        .form-check-input {
            background-color: var(--input-bg);
            border-color: var(--input-border);
            width: 14px;
            height: 14px;
            margin-top: 3px;
        }
        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }
        
        .form-check-label {
            font-size: 0.8rem;
        }

        a { color: var(--accent); text-decoration: none; transition: 0.2s; }
        a:hover { color: var(--accent-hover); text-decoration: underline; }
    </style>
</head>
<body>

    <div class="glow"></div>

    <div class="login-card text-center">
        <div class="brand-logo">
            <i class="bi bi-tsunami"></i>
        </div>

        <h4>Welcome Back</h4>
        <p class="subtitle">Fish Feeder Control Panel</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 mb-3 small text-start border-0" style="background: rgba(220, 53, 69, 0.1); color: #ff6b6b;">
                <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="text-start">
            @csrf
            
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" placeholder="name@example.com" required autofocus style="border-left: none;">
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="••••••••" required style="border-left: none;">
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember">
                        Remember me
                    </label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Sign In
            </button>
        </form>
    </div>

</body>
</html>