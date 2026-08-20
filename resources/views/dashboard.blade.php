<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <!-- Flash Messages (Success & Error) -->
                @if (session('status'))
                    <div class="mb-6 p-4 text-sm font-medium text-green-700 bg-green-100 rounded-lg text-center">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 p-4 text-sm font-medium text-red-700 bg-red-100 rounded-lg text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Status Display -->
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    @if ($status === 'Working')
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Working
                        </span>
                    @elseif ($status === 'On Break')
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            On Break
                        </span>
                    @elseif ($status === 'Clocked Out')
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                            Clocked Out
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">
                            Not Clocked In
                        </span>
                    @endif
                </div>

                <!-- Clock Action Buttons -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                    <!-- 1. Clock In -->
                    <form action="{{ route('clock.in') }}" method="POST">
                        @csrf
                        <button type="submit"
                            @if($status !== 'Not Clocked In') disabled @endif
                            class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-indigo-600">
                            Clock In
                        </button>
                    </form>

                    <!-- 2. Clock Out -->
                    <form action="{{ route('clock.out') }}" method="POST">
                        @csrf
                        <button type="submit"
                            @if($status !== 'Working') disabled @endif
                            class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-red-600">
                            Clock Out
                        </button>
                    </form>

                    <!-- 3. Break Start -->
                    <form action="{{ route('break.start') }}" method="POST">
                        @csrf
                        <button type="submit"
                            @if($status !== 'Working') disabled @endif
                            class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-amber-500">
                            Break Start
                        </button>
                    </form>

                    <!-- 4. Break End -->
                    <form action="{{ route('break.end') }}" method="POST">
                        @csrf
                        <button type="submit"
                            @if($status !== 'On Break') disabled @endif
                            class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow transition duration-150 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:bg-emerald-600">
                            Break End
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
