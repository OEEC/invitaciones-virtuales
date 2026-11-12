<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Panel' }} · Invitaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-50 text-stone-800">
    <header class="bg-white border-b">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="{{ route('admin.invitations') }}" class="font-semibold text-amber-700">💌 Invitaciones</a>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="text-sm text-stone-500 hover:text-stone-800">Salir</button>
            </form>
        </div>
    </header>
    <main class="max-w-5xl mx-auto px-4 py-8">{{ $slot }}</main>
</body>
</html>