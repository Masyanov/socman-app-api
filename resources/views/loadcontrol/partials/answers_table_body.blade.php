<tbody>
@foreach($answers as $answer)
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-6 py-4">
            <a id="button_del_user" href="javascript:void(0)"
               class="p-2 rounded-md bg-red-500 hover:bg-red-700 flex h-full"
               onclick="deleteAnswer({{ $answer->id }})"
               title="{{ __('messages.Удалить') }}">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                       stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                            stroke="#d1d1d1" stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
            </a>
        </td>
        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $answer->created_at)->format('d.m.y') }}
        </th>
        <td class="px-6 py-4">
            {{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $answer->created_at)->format('H:i') }}
        </td>
        <td class="px-6 py-4">
            {{ nameLastname($answer->user_id) }}
        </td>
        <td class="px-6 py-4">
            {{ playerPosition($answer->user_id)  }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->team_code }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->pain ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->local ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->sleep ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->sleep_time ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->moral ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->physical ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            @if($answer->presence_checkNum)
                {{ __('messages.Да') }}
            @else
                {{ __('messages.Нет') }}
            @endif
        </td>
        <td class="px-6 py-4">
            {{ $answer->cause ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->recovery ?? 'None' }}
        </td>
        <td class="px-6 py-4">
            {{ $answer->load ?? 'None'}}
        </td>
    </tr>
@endforeach
</tbody>
