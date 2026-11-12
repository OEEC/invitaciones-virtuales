<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acceso · Invitaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 min-h-screen flex items-center justify-center p-4">
    <form method="POST" action="{{ route('login') }}" class="bg-white shadow rounded-xl p-8 w-full max-w-sm space-y-4">
        @csrf
        <h1 class="text-xl font-semibold text-amber-700">💌 Invitaciones</h1>
        <div>
            <label class="text-sm">Correo</label>
            <input name="email" type="email" value="{{ old('email') }}" required class="w-full border rounded px-3 py-2">
            @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm">Contraseña</label>
            <input name="password" type="password" required class="w-full border rounded px-3 py-2">
        </div>
        <button class="w-full bg-amber-600 hover:bg-amber-700 text-white rounded py-2">Entrar</button>
    </form>
</body>
</html>