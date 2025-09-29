<table class="table-auto border-collapse border border-gray-300 text-sm">
    <thead>
    <tr>
        <th class="border border-gray-300 px-2 py-1 text-left">Фамилия Имя</th>
        @foreach($days as $day)
            <th class="border border-gray-300 px-1 py-1 text-center">
                {{ $day->format('d') }}
            </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td class="border border-gray-300 px-2 py-1">
                {{ $user->last_name }} {{ $user->first_name }}
            </td>
            @foreach($days as $day)
                @php
                    $key = $user->id . '_' . $day->toDateString();
                    $isPresent = isset($presences[$key]);
                @endphp
                <td class="border border-gray-300 px-1 py-1 text-center
                        {{ $isPresent ? 'bg-green-100' : 'bg-red-100' }}">
                    {{ $isPresent ? 'Я' : 'Н' }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
