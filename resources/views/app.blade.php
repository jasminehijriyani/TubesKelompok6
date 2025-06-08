<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'My Laravel App')</title>
</head>
<body>

    {{-- Flash messages --}}
    @if (session('success'))
        <div style="background: #d4edda; padding: 10px; margin: 10px 0; color: #155724;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #f8d7da; padding: 10px; margin: 10px 0; color: #721c24;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Main content --}}
    <div>
        @yield('content')
    </div>

</body>
</html>
