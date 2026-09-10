@if (session('status'))
    <div class="mb-6 p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg text-center shadow">
        {{ session('status') }}
    </div>
@endif

@if (session('success'))
    <div class="mb-6 p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg text-center shadow">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-6 p-4 text-sm font-medium text-red-700 bg-red-100 rounded-lg text-center shadow">
        {{ session('error') }}
    </div>
@endif