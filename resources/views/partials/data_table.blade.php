
<div class="relative overflow-x-auto">
    <table
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="px-6 py-3">
                {{ __('messages.Имя') }}
            </th>
            @foreach($datesForSelect as $date)
                <th scope="col"
                    class="w-40 px-6 py-3 text-center">{{  dateFormatDM($date) }}</th>
            @endforeach
            <th scope="col" class="w-40 px-6 py-3 text-center">
                {{ __('messages.Среднее') }}
            </th>
        </tr>
        </thead>
        <tbody>

        @foreach($results as $userId => $answers)

            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row"
                    class="px-4 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ nameLastnameBreak($userId) }}
                </th>
                @foreach($answers as $key => $data)
                    <td class="px-4 py-2">
                        @if($data['recovery'] || $data['load'])
                            <div class="modal_condition flex align-items-center cursor-pointer relative"
                                 data-modal-condition-userid="{{ $userId }}" data-modal-condition-date="{{ $key }}"
                                 data-modal-target="modal_condition"
                                 data-modal-toggle="modal_condition">
                                <div
                                    class="w-full min-w-10 flex justify-end bg-gray-200 h-6 dark:bg-gray-700 relative rounded-l">
                                    <div
                                        class="w-0 bg-indigo-600 h-6 dark:bg-indigo-500 rounded-l"
                                        @if(is_numeric($data['recovery']))
                                        style="width: {{ $data['recovery'] }}%"
                                        @endif
                                    >
                                        <div
                                            class="absolute min-w-10 top-0.5 left-0 text-left w-full text-xs font-bold ps-1">
                                            @if(is_numeric($data['recovery']))
                                                {{ $data['recovery'] }}%
                                            @endif
                                        </div>
                                    </div>
                                    @if($data['recovery_planned'])
                                        <div
                                            class="absolute h-6 top-0 border-l-2 border-l-blue-500 border-dotted"
                                            data-planned
                                            style="width: {{ $data['recovery_planned'] }}%">
                                            <div
                                                class="absolute min-w-10 -top-4 -left-2.5 text-gray-600 text-left w-full text-2xs">
                                                {{ $data['recovery_planned'] }}%
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div
                                    class="w-full min-w-10 bg-gray-200 h-6 dark:bg-gray-700 relative rounded-r">
                                    <div
                                        class="w-0 bg-rose-800 h-6 dark:bg-rose-800 rounded-r"
                                        @if(is_numeric($data['load']))
                                            style="width: {{ $data['load'] }}%"
                                        @endif
                                    >
                                        <div
                                            class="absolute min-w-10 top-0.5 right-0 text-right w-full text-xs font-bold pe-1">
                                            @if(is_numeric($data['load']))
                                                {{ $data['load'] }}%
                                            @endif
                                        </div>
                                    </div>
                                    @if($data['load_planned'])
                                        <div
                                            class="absolute h-6 top-0 border-r-2 border-dotted" data-planned
                                            style="width: {{ $data['load_planned'] }}%; border-right-color: #7e4952;">
                                            <div
                                                class="absolute min-w-10 -top-4 -right-2.5 text-gray-600 text-right w-full text-2xs">
                                                {{ $data['load_planned'] }}%
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if(checkExtraLoadControlForCoach())
                                    <span
                                        class="bg-blue-200 text-xs font-medium text-blue-800 text-center p-0.5 pt-1 pb-1 leading-none rounded-full px-2 dark:bg-blue-900 dark:text-blue-200 absolute translate-y-1/2 translate-x-1/2 bottom-0 right-1/2"
                                        style="background:{{ generalConditionColor($data['general-condition']) }}">{{ generalConditionSvg($data['general-condition']) }}</span>
                                @endif
                            </div>
                        @else
                            <div class="flex justify-center align-items-center">
                                <span
                                    class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-gray-700 dark:text-gray-300">{{ __('messages.Нет') }}</span>
                            </div>
                        @endif

                    </td>
                @endforeach
                    <?php
                    $totalRecovery = 0;
                    $countRecovery = 0;

                    $totalLoad = 0;
                    $countLoad = 0;

                    foreach ( $answers as $date => $data ) {
                        if (isset($data['recovery']) && is_numeric($data['recovery']) && $data['recovery'] != 0) {
                            $totalRecovery += (int)$data['recovery'];
                            $countRecovery++;
                        }
                        if (isset($data['load']) && is_numeric($data['load']) && $data['load'] != 0) {
                            $totalLoad += (int)$data['load'];
                            $countLoad++;
                        }
                    }

                    $averageRecovery = ( $countRecovery > 0 ) ? ( $totalRecovery / $countRecovery ) : 0;
                    $averageLoad     = ( $countLoad > 0 ) ? ( $totalLoad / $countLoad ) : 0;

                    ?>
                <td class="px-4 py-2 bg-gray-700 dark:bg-gray-700">

                    <div class="flex">
                        <div
                            class="w-full  min-w-10 flex justify-end bg-gray-200 h-6 bg-gray-800 relative rounded-l">
                            <div
                                class="bg-indigo-600 h-6 dark:bg-indigo-500 rounded-l"
                                style="width: {{ $averageRecovery ?? '0' }}%"
                            >
                                <div
                                    class="absolute  min-w-10 bottom-0.5 right-0 text-center w-full">{{ round($averageRecovery, 0) ?? '0' }}
                                    %
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-full  min-w-10 bg-gray-200 h-6 bg-gray-800 relative rounded-r">
                            <div
                                class="bg-rose-800 h-6 dark:bg-rose-800 rounded-r"
                                style="width: {{ $averageLoad ?? '0' }}%">
                                <div
                                    class="absolute  min-w-10 bottom-0.5 text-center w-full">{{ round($averageLoad, 0) ?? '0' }}
                                    %
                                </div>
                            </div>
                        </div>
                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<div id="modal_condition" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed z-50 w-full md:inset-0 h-[calc(100%-1rem)] max-h-full flex justify-center items-center">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="modal_condition">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only"> {{ __('messages.Закрыть окно') }}</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <div
                    class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('messages.Подробное состояние игрока - ') }}
                        <h4></h4>

                    </h3>
                </div>
                <div class="px-3 py-2">
                    <div
                        class="w-full text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg fill="currentColor" class="w-5 h-5 me-2.5" viewBox="0 0 32 32" version="1.1"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier"><title>pill</title>
                                        <path
                                            d="M28.987 7.898c-1.618-2.803-5.215-3.779-8.010-2.146-9.273 5.417-6.35 3.666-15.822 9.135v0c-2.803 1.618-3.764 5.207-2.146 8.010s5.214 3.777 8.010 2.146c9.447-5.512 6.518-3.772 15.822-9.135 2.804-1.616 3.765-5.207 2.146-8.010zM26.544 15.141l-7.751 4.475c0.424-0.245 0.679-0.623 0.796-1.089 1.068-0.623 2.463-1.428 5.298-3.054 0.834-0.478 1.459-1.163 1.851-1.969l-0-0c0.654-1.343 0.644-2.99-0.153-4.376-0.115-0.2-0.262-0.368-0.401-0.544 0.679 2.050-0.15 4.373-2.097 5.489-2.236 1.282-3.578 2.057-4.571 2.636-0.417-1.701-1.638-3.688-2.945-4.926-1.888 1.115-2.616 1.559-7.348 4.271-1.921 1.101-2.752 3.377-2.122 5.407-0.023-0.012-0.046-0.024-0.069-0.036-0.109-0.135-0.217-0.27-0.306-0.426-0.797-1.387-0.807-3.033-0.153-4.376l-0-0c0.392-0.806 1.017-1.49 1.851-1.969 4.175-2.393 5.228-3.010 6.71-3.88-0.534-0.23-1.037-0.262-1.455-0.017l7.751-4.475c5.215-3.011 10.413 5.8 5.115 8.859z"></path>
                                    </g>
                                </svg>
                                {{ __('messages.Дискомфорт') }}

                            </div>
                            <div class="flex gap-1 items-center" data-cond="pain" id="pain">

                            </div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg class="w-5 h-5 me-2.5" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                     xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <style type="text/css"> .st0 {
                                                fill: currentColor;
                                            } </style>
                                        <g>
                                            <path class="st0"
                                                  d="M54.726,96.776c26.718,0,48.389-21.665,48.389-48.388C103.114,21.665,81.444,0,54.726,0 C28.003,0,6.337,21.665,6.337,48.389C6.337,75.112,28.003,96.776,54.726,96.776z"></path>
                                            <path class="st0"
                                                  d="M301.32,79.438l-110.641-8.353c-59.428-0.414-113.957,27.86-127.658,68.495v0.017l-48.768,147.95 c-3.114,9.921,2.397,20.494,12.322,23.604c9.929,3.119,20.493-2.405,23.616-12.326l59.006-123.166 c4.634-5.507,8.798-3.365,10.242-2.052c8.89,8.132,26.926,37.639,30.274,53.005c2.639,12.079-3.3,29.744-10.256,42.97 l-43.556,73.851c-3.714,6.203-6.793,12.758-6.537,18.705l8.022,127.774c0,12.193,9.886,22.088,22.092,22.088 c12.199,0,22.094-9.895,22.094-22.088l7.551-117.042l55.565-75.279c0.449-0.696,2.942-2.228,1.643,1.842 c-0.023,0.053-9.974,41.807-9.974,41.807c-1.643,5.463-1.554,9.27-1.506,13.754l9.392,127.667 c0.137,12.203,10.133,21.983,22.327,21.851c12.207-0.132,21.995-10.132,21.859-22.336l6.423-121.182l27.908-78.539 c16.115-42.521-27.062-132.478-51.648-155.43h45.833l2.582,77.798c-0.688,9.331,6.334,17.454,15.67,18.124 c9.335,0.688,17.459-6.326,18.128-15.665c0,0,9.322-102.557,9.369-103.139C323.616,91.42,314.043,80.353,301.32,79.438z"></path>
                                            <polygon class="st0"
                                                     points="396.485,140.857 442.058,85.798 425.23,75.666 372.216,144.769 388.053,153.262 342.598,206.682 355.348,213.299 413.269,150.769 "></polygon>
                                            <polygon class="st0"
                                                     points="505.663,198.083 496.544,180.664 415.326,212.127 424.455,227.625 357.85,249.634 365.304,261.908 447.296,238.604 438.106,221.396 "></polygon>
                                        </g>
                                    </g></svg>
                                {{ __('messages.Место') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="local" id="local"></div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">

                                <svg class="w-5 h-5 me-2.5" viewBox="0 0 192 192" xmlns="http://www.w3.org/2000/svg"
                                     fill="currentColor">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                           stroke-width="12" clip-path="url(#a)">
                                            <path d="M30 22h62L30 96h62m25-24h46l-46 55h46m-109 0h36l-36 43h36"></path>
                                        </g>
                                    </g>
                                </svg>
                                {{ __('messages.Сон') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="sleep" id="sleep"></div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg class="w-5 h-5 me-2.5" viewBox="0 0 24 24" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <circle cx="12" cy="12" r="8" stroke="currentColor" stroke-width="2"></circle>
                                        <path d="M5 2.80385C4.08789 3.33046 3.33046 4.08788 2.80385 5"
                                              stroke="currentColor"
                                              stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M19 2.80385C19.9121 3.33046 20.6695 4.08788 21.1962 5"
                                              stroke="currentColor"
                                              stroke-width="2" stroke-linecap="round"></path>
                                        <path
                                            d="M9 9H14.6379C14.7715 9 14.8384 9.16157 14.7439 9.25607L9.25607 14.7439C9.16157 14.8384 9.2285 15 9.36213 15H15"
                                            stroke="inherit" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"></path>
                                    </g>
                                </svg>
                                {{ __('messages.Время засыпания') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="sleep_time" id="sleep_time"></div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg class="w-5 h-5 me-2.5" viewBox="0 0 24 24" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M12 1C12.5523 1 13 1.44772 13 2V3.03241C14.2498 3.11076 15.4551 3.31872 16.4996 3.51766C16.7363 3.56274 16.9614 3.6067 17.1766 3.64875C17.5772 3.72697 17.9442 3.79865 18.2885 3.85854C18.8201 3.95099 19.2169 4 19.5 4C20.0262 4 20.4799 3.824 20.8164 3.63176C20.987 3.53425 21.1544 3.42192 21.2985 3.28732C21.6895 2.90238 22.3185 2.90423 22.7071 3.29289C23.0976 3.68342 23.0976 4.31658 22.7071 4.70711C22.6248 4.78929 22.5358 4.8645 22.445 4.93712C22.2947 5.05735 22.08 5.21318 21.8086 5.36824C21.5531 5.51425 21.2396 5.66392 20.8766 5.7809L23.592 12.7633C23.8408 13.403 24.0883 14.3096 23.7733 15.2388C23.5809 15.8064 23.2111 16.5114 22.5024 17.0733C21.7828 17.6438 20.7978 18 19.5 18C18.2022 18 17.2172 17.6438 16.4976 17.0733C15.7889 16.5114 15.4191 15.8064 15.2267 15.2388C14.9117 14.3096 15.1592 13.403 15.408 12.7633L18.0948 5.85438C17.6825 5.78545 17.2363 5.69819 16.7643 5.60606C16.5535 5.5649 16.3394 5.5231 16.1254 5.48234C15.1314 5.293 14.0689 5.11204 13 5.03671V21H17C17.5523 21 18 21.4477 18 22C18 22.5523 17.5523 23 17 23H7C6.44772 23 6 22.5523 6 22C6 21.4477 6.44772 21 7 21H11V5.03671C9.93106 5.11204 8.86863 5.293 7.87462 5.48234C7.66063 5.5231 7.44651 5.5649 7.23567 5.60606C6.76375 5.69819 6.31749 5.78545 5.90522 5.85438L8.59203 12.7633C8.84079 13.403 9.08831 14.3096 8.77332 15.2388C8.58095 15.8064 8.21113 16.5114 7.50239 17.0733C6.78283 17.6438 5.79781 18 4.5 18C3.20219 18 2.21717 17.6438 1.49762 17.0733C0.788879 16.5114 0.419057 15.8064 0.226689 15.2388C-0.0883047 14.3096 0.15921 13.403 0.407975 12.7633L3.12336 5.7809C2.7604 5.66392 2.44688 5.51425 2.19136 5.36824C1.92 5.21318 1.70529 5.05735 1.555 4.93712C1.54623 4.9301 1.2929 4.70711 1.2929 4.70711C0.902372 4.31658 0.902372 3.68342 1.2929 3.29289C1.68155 2.90424 2.31052 2.90238 2.70147 3.2873C2.71455 3.29973 2.89568 3.46721 3.18364 3.63176C3.52007 3.824 3.97378 4 4.5 4C4.78311 4 5.17989 3.95099 5.71147 3.85854C6.05594 3.79863 6.42267 3.72701 6.8233 3.64876C7.03851 3.60673 7.26382 3.56272 7.50039 3.51766C8.54486 3.31872 9.75016 3.11076 11 3.03241V2C11 1.44772 11.4477 1 12 1ZM4.5 7.75903L2.46185 13H6.53816L4.5 7.75903ZM2.74016 15.5061C2.55191 15.3569 2.4102 15.1818 2.30351 15H6.6965C6.58981 15.1818 6.44809 15.3569 6.25985 15.5061C5.94444 15.7562 5.41585 16 4.5 16C3.58416 16 3.05556 15.7562 2.74016 15.5061ZM17.4618 13L19.5 7.75903L21.5382 13H17.4618ZM17.3035 15C17.4102 15.1818 17.5519 15.3569 17.7402 15.5061C18.0556 15.7562 18.5842 16 19.5 16C20.4158 16 20.9444 15.7562 21.2598 15.5061C21.4481 15.3569 21.5898 15.1818 21.6965 15H17.3035Z"
                                              fill="currentColor"></path>
                                    </g>
                                </svg>
                                {{ __('messages.Моральное состояние') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="moral" id="moral"></div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg class="w-5 h-5 me-2.5" fill="currentColor" version="1.1" id="Capa_1"
                                     xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 471.787 471.787"
                                     xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <g id="_x35_1_20_">
                                                <path
                                                    d="M360.852,35.142c-15.477-18.056-102.336-61.626-149.625-12.615c-47.29,49.01,2.952,83.636,21.012,91.97 c18.057,8.334,69.647,21.066,88.354-11.607c4.99,12.785,1.623,119.131-27.865,146.17c-14.942-14.246-36.51-23.19-60.488-23.19 c-19.689,0-37.746,6.031-51.85,16.073c-18.619-29.884-53.845-50.062-94.271-50.062c-19.383,0-37.563,4.659-53.308,12.782v10.448 c-0.013-0.003-0.056-0.013-0.056-0.013v256.662c0,0,74.807,3.87,80.791-82.544c-0.002-0.005-0.005-0.01-0.005-0.015 c18.198,26.427,76.18,46.541,111.909,45.355c56.121-1.861,130.693-4.321,193.865-64.881c5.838-5.809,10.52-12.669,13.701-20.259 c0-0.002,0-0.002,0-0.004C462.242,288.615,376.328,53.198,360.852,35.142z"></path>
                                            </g>
                                        </g>
                                    </g></svg>
                                {{ __('messages.Физическое состояние') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="physical" id="physical"></div>
                        </div>
                        <div
                            class="relative flex gap-2 justify-between items-center w-full px-4 py-2 text-sm font-medium border-b border-gray-200 rounded-t-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-gray-600 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-500 dark:focus:text-white">
                            <div class="flex gap-1 items-center">
                                <svg class="w-5 h-5 me-2.5" viewBox="0 0 24 24" fill="currentColor"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g id="Interface / Main_Component">
                                            <g id="Vector">
                                                <path
                                                    d="M11.2348 2.37392C10.8672 2.52616 10.5377 2.85565 9.8788 3.51457C9.22003 4.17335 8.8904 4.50298 8.73818 4.87047C8.53519 5.36053 8.53519 5.91121 8.73818 6.40126C8.89042 6.76881 9.21989 7.09828 9.87883 7.75722C10.5374 8.41578 10.8673 8.74568 11.2347 8.89788C11.7248 9.10086 12.2755 9.10086 12.7655 8.89787C13.1331 8.74563 13.4625 8.41616 14.1215 7.75722C14.7804 7.09828 15.1089 6.76881 15.2612 6.40126C15.4641 5.91121 15.4641 5.36053 15.2612 4.87047C15.1089 4.50293 14.7804 4.17351 14.1215 3.51457C13.4625 2.85564 13.1331 2.52616 12.7655 2.37392C12.2755 2.17093 11.7248 2.17093 11.2348 2.37392Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M4.8705 8.73769C4.50296 8.88993 4.17348 9.21941 3.51455 9.87834C2.85579 10.5371 2.52614 10.8668 2.37392 11.2342C2.17093 11.7243 2.17093 12.275 2.37392 12.765C2.52616 13.1326 2.85564 13.4621 3.51457 14.121C4.17314 14.7796 4.50303 15.1094 4.87047 15.2616C5.36053 15.4646 5.91121 15.4646 6.40126 15.2616C6.76881 15.1094 7.09828 14.7799 7.75722 14.121C8.41616 13.4621 8.74466 13.1326 8.8969 12.765C9.09989 12.275 9.09989 11.7243 8.8969 11.2342C8.74466 10.8667 8.41616 10.5373 7.75722 9.87834C7.09828 9.2194 6.76881 8.88993 6.40126 8.73769C5.91121 8.5347 5.36056 8.5347 4.8705 8.73769Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M16.2431 9.87834C15.5843 10.5371 15.2547 10.8667 15.1024 11.2342C14.8994 11.7243 14.8994 12.275 15.1024 12.765C15.2547 13.1326 15.5842 13.462 16.2431 14.121C16.9016 14.7795 17.2316 15.1094 17.599 15.2616C18.089 15.4646 18.6397 15.4646 19.1298 15.2616C19.4973 15.1094 19.8268 14.7799 20.4857 14.121C21.1447 13.4621 21.4732 13.1326 21.6254 12.765C21.8284 12.275 21.8284 11.7243 21.6254 11.2342C21.4732 10.8667 21.1447 10.5373 20.4857 9.87834C19.8268 9.21941 19.4973 8.88993 19.1298 8.73769C18.6397 8.5347 18.0891 8.5347 17.599 8.73769C17.2315 8.88993 16.902 9.21941 16.2431 9.87834Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                                <path
                                                    d="M11.2348 15.1019C10.8672 15.2542 10.5377 15.5837 9.8788 16.2426C9.22004 16.9014 8.8904 17.231 8.73818 17.5985C8.53519 18.0886 8.53519 18.6392 8.73818 19.1293C8.89042 19.4968 9.21989 19.8263 9.87883 20.4852C10.5374 21.1438 10.8673 21.4737 11.2347 21.6259C11.7248 21.8289 12.2755 21.8289 12.7655 21.6259C13.1331 21.4737 13.4625 21.1442 14.1215 20.4852C14.7804 19.8263 15.1089 19.4968 15.2612 19.1293C15.4641 18.6392 15.4641 18.0886 15.2612 17.5985C15.1089 17.231 14.7804 16.9015 14.1215 16.2426C13.4625 15.5837 13.1331 15.2542 12.7655 15.1019C12.2755 14.899 11.7248 14.899 11.2348 15.1019Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"></path>
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                                {{ __('messages.Общее состояние') }}
                            </div>
                            <div class="flex gap-1 items-center" data-cond="general-condition"
                                 id="general-condition"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
