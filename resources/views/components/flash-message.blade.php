@if (session('success'))
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow">
        {{ session('error') }}
    </div>
@endif