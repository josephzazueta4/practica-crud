<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-gray-100">

    <!-- Barra de navegación -->
    <nav class="bg-blue-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('empleados.index') }}" class="text-white text-lg font-semibold">Gestión de Empleados</a>

            <!-- Menú de usuario (ejemplo con nombre del usuario autenticado) -->
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-white">Bienvenido, {{ Auth::user()->name }}</span>
                    <a href="{{ route('logout') }}" class="text-white">Cerrar sesión</a>
                @else
                    <a href="{{ route('login') }}" class="text-white">Iniciar sesión</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div id="app" class="container mx-auto p-4">
        @yield('content')
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
