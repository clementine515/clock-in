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
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">
                        Not Clocked In
                    </span>
                </div>

                <!-- Clock Action Buttons -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                    <!-- Clock In (フォーム化 & submitに変更) -->
                    <form action="{{ route('clock.in') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition duration-150">
                            Clock In
                        </button>
                    </form>

                    <!-- Clock Out (フォーム化 & submitに変更) -->
                    <form action="{{ route('clock.out') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition duration-150">
                            Clock Out
                        </button>
                    </form>

                    <!-- Break Start (Day 7で実装予定) -->
                    <button type="button" disabled class="w-full py-4 bg-amber-500 text-white font-bold rounded-lg shadow opacity-50 cursor-not-allowed">
                        Break Start
                    </button>

                    <!-- Break End (Day 7で実装予定) -->
                    <button type="button" disabled class="w-full py-4 bg-emerald-600 text-white font-bold rounded-lg shadow opacity-50 cursor-not-allowed">
                        Break End
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
