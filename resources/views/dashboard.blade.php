<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <!-- Status Display -->
                <div class="text-center mb-8">
                    <p class="text-sm text-gray-500 mb-1">Status</p>
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-700">
                        Not Clocked In
                    </span>
                </div>

                <!-- Clock Action Buttons -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-2xl mx-auto">
                    <!-- Clock In -->
                    <button type="button" class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow transition duration-150">
                        Clock In
                    </button>

                    <!-- Clock Out -->
                    <button type="button" class="w-full py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition duration-150">
                        Clock Out
                    </button>

                    <!-- Break Start -->
                    <button type="button" class="w-full py-4 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-lg shadow transition duration-150">
                        Break Start
                    </button>

                    <!-- Break End -->
                    <button type="button" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg shadow transition duration-150">
                        Break End
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
