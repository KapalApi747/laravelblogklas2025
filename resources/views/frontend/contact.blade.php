<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Laravel</title>
</head>
<body>
@can('ViewAdminPanel', App\Models\User::class)
    <a href="{{ route('backend.index') }}">Admin Dashboard</a>
@endcan
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-6">Contactformulier</h1>

        @if(session('status'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 border border-green-200 rounded">
                {{ session('status') }}
            </div>
        @endif
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                <input type="text" name="name" class="mt-1 block w-full rounded-lg border border-gray-400 bg-white shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" class="mt-1 block w-full rounded-lg border border-gray-400 bg-white shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Bericht</label>
                <textarea name="message" rows="4" class="mt-1 block w-full rounded-lg border border-gray-400 bg-white shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" required></textarea>
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition shadow-md">Verzenden</button>
        </form>
    </div>
</div>



</body>
</html>

