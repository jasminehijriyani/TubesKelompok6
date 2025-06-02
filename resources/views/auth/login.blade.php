<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Library E-Commerce</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
            backdrop-filter: blur(5px);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="email"], input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }
        input[type="email"]:focus, input[type="password"]:focus {
            border-color: #6a11cb;
            outline: none;
        }
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            transition: opacity 0.3s ease;
            margin-top: 10px;
        }
        button:hover {
            opacity: 0.9;
        }
        p {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        a {
            color: #6a11cb;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        a:hover {
            color: #2575fc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Masuk</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div style="color: red; margin-bottom: 15px; text-align: left;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <input type="email" id="email" name="email" placeholder="Alamat Email" required value="{{ old('email') }}">
            {{-- Display error for email field --}}
            @error('email')
                <div style="color: red; font-size: 0.8em; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</div>
            @enderror

            <input type="password" id="password" name="password" placeholder="Kata Sandi" required>
            {{-- Display error for password field --}}
            @error('password')
                <div style="color: red; font-size: 0.8em; margin-top: -10px; margin-bottom: 10px;">{{ $message }}</div>
            @enderror

            <button type="submit">Masuk</button>
        </form>
        <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
    </div>
</body>
</html> 