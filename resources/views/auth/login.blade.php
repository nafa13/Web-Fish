<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fish Feeder | Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .login-card {
            width: 360px;
            border-radius: 14px;
        }

        .btn-login {
            background: #007bff;
            border: none;
        }

        .btn-login:hover {
            background: #0056c7;
        }

        .logo {
            font-size: 38px;
        }

        .input-group-text {
            background-color: #fff;
            border-right: none;
        }

        input.form-control {
            border-left: none;
        }

        input.form-control:focus {
            box-shadow: none;
        }
    </style>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow p-4 login-card">
        <div class="text-center mb-3">
            <span class="logo">🐠</span>
            <h4 class="fw-bold">Fish Feeder Login</h4>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger text-center py-2">
                <small>{{ $errors->first() }}</small>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="mb-3 input-group">
                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <button class="btn btn-login text-white w-100 py-2">Login</button>
        </form>
    </div>

</body>

</html>
