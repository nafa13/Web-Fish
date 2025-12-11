<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Fish Feeder</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .login-container {
            height: 100vh;
        }

        /* BAGIAN KIRI (BRANDING) */
        .brand-section {
            background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
            position: relative;
            overflow: hidden;
            color: white;
        }

        .brand-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.6;
        }

        .fish-decoration {
            position: absolute;
            font-size: 15rem;
            color: rgba(255,255,255,0.1);
            bottom: -50px;
            right: -50px;
            transform: rotate(-15deg);
        }

        /* BAGIAN KANAN (FORM) */
        .form-section {
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }

        .form-control {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-label {
            font-weight: 500;
            color: #475569;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: linear-gradient(90deg, #2563eb 0%, #0061ff 100%);
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            transition: transform 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(37, 99, 235, 0.3);
        }

        .brand-icon-mobile {
            font-size: 2.5rem;
            background: linear-gradient(135deg, #0061ff 0%, #60efff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

    <div class="row g-0 login-container">
        
        <div class="col-lg-6 d-none d-lg-flex flex-column justify-content-center align-items-center brand-section p-5">
            <div class="brand-pattern"></div>
            
            <div style="z-index: 2; text-align: center;">
                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4 shadow-lg" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-tsunami"></i>
                </div>
                <h1 class="fw-bold display-5 mb-3">Fish Feeder IoT</h1>
                <p class="lead opacity-75">Kelola jadwal pakan ikan Anda secara cerdas,<br>kapan saja dan di mana saja.</p>
            </div>

            <i class="bi bi-water fish-decoration"></i>
        </div>

        <div class="col-lg-6 form-section">
            <div class="login-wrapper">
                
                <div class="text-center d-lg-none mb-4">
                    <i class="bi bi-tsunami brand-icon-mobile"></i>
                    <h3 class="fw-bold mt-2">Fish Feeder</h3>
                </div>

                <div class="mb-5">
                    <h2 class="fw-bold text-dark">Welcome Back! 👋</h2>
                    <p class="text-muted">Silakan masuk untuk mengelola alat Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 d-flex align-items-center mb-4" role="alert" style="background-color: #fee2e2; color: #ef4444;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <small>{{ $errors->first() }}</small>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukan password..." required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label text-muted small" for="remember">
                                Ingat saya
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3">
                        Masuk ke Dashboard <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="text-center mt-5 text-muted small">
                    &copy; {{ date('Y') }} Smart Fish Feeder System
                </div>
            </div>
        </div>
    </div>

</body>
</html>