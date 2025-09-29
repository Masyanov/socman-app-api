<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-400">
        <thead class="text-xs uppercase bg-gray-700 text-gray-400">
        <tr>
            <th scope="col" class="px-4 py-3">Имя</th>
            @foreach($days as $day)
                <th scope="col" class="px-4 py-3 text-center">
                    {{ $day->format('d.m') }}
                </th>
            @endforeach
            <th scope="col" class="px-4 py-3 text-center">Посещаемость</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            @php
                // Counting presence for this user
                $totalDays = count($days);
                $attended = 0;
                foreach ($days as $day) {
                    $key = $user->id . '_' . $day->toDateString();
                    if (isset($presences[$key])) {
                        $attended++;
                    }
                }
                $attendancePercent = $totalDays > 0
                    ? round(($attended / $totalDays) * 100)
                    : 0;
            @endphp
            <tr class="border-b border-gray-700 hover:bg-gray-800">
                <td class="px-4 py-3 text-white">
                    {{ $user->last_name }} {{ $user->name }}
                </td>
                @foreach($days as $day)
                    @php
                        $key = $user->id . '_' . $day->toDateString();
                        $isPresent = isset($presences[$key]);
                    @endphp
                    <td class="px-4 py-3 text-center">
                        @if($isPresent)
                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-green-600 text-white text-xs font-medium">
                                ✓
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full bg-red-600 text-white text-xs font-medium">
                                ×
                            </span>
                        @endif
                    </td>
                @endforeach
                <td class="px-4 py-3 text-center font-bold text-white">
                    {{ $attendancePercent }}%
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
