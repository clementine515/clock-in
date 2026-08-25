<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daily Attendance List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">

                <!-- Date Navigation (Prev / Today / Next) -->
                <div class="flex items-center justify-between mb-6 max-w-md mx-auto">
                    <a href="{{ route('daily.list', ['date' => $prevDate]) }}"
                       class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded shadow transition">
                        ＜ Prev
                    </a>

                    <div class="text-center">
                        <span class="text-xl font-bold text-gray-800">{{ $current->format('Y-m-d') }}</span>
                        <a href="{{ route('daily.list') }}" class="block text-xs text-indigo-600 hover:underline mt-1">
                            Go to Today
                        </a>
                    </div>

                    <a href="{{ route('daily.list', ['date' => $nextDate]) }}"
                       class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded shadow transition">
                        Next ＞
                    </a>
                </div>

                <!-- Attendance Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Clock In</th>
                                <th scope="col" class="px-6 py-3">Clock Out</th>
                                <th scope="col" class="px-6 py-3">Break Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($records as $record)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $record->user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->checkin_time ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->checkout_time ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $record->breaks->count() }} time(s)
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                        No attendance records found for this date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>