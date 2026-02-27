@if(Auth::user()->role == 'coach' || Auth::user()->role == 'admin')
    <x-app-layout>
        <x-slot name="header">
            <div class="flex flex-col gap-3 sm:flex-row items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('messages.Тренировки') }}
                </h2>
                @if(session('success'))
                    <div id="classificationCreate"
                         class="fixed top-3 right-2 flex opacity-1 z-10 items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-700"
                         role="alert">
                        <div
                            class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            <span class="sr-only">Check icon</span>
                        </div>
                        <div class="ms-3 text-sm font-normal">{{ session('success') }}</div>
                        <button type="button"
                                class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                                data-dismiss-target="#classificationCreate" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2"
                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>
                @endif
                <div class="flex gap-3">

                    @if(CountTeam() > 0)
                        <!-- Modal toggle -->
                        <button data-modal-target="settings_training" data-modal-toggle="settings_training"
                                class="px-5 py-2.5 text-sm font-medium text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                type="button">
                            <svg class="w-3.5 h-3.5 text-white me-2" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M12 8.25C9.92894 8.25 8.25 9.92893 8.25 12C8.25 14.0711 9.92894 15.75 12 15.75C14.0711 15.75 15.75 14.0711 15.75 12C15.75 9.92893 14.0711 8.25 12 8.25ZM9.75 12C9.75 10.7574 10.7574 9.75 12 9.75C13.2426 9.75 14.25 10.7574 14.25 12C14.25 13.2426 13.2426 14.25 12 14.25C10.7574 14.25 9.75 13.2426 9.75 12Z"
                                          fill="#ffffff"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M11.9747 1.25C11.5303 1.24999 11.1592 1.24999 10.8546 1.27077C10.5375 1.29241 10.238 1.33905 9.94761 1.45933C9.27379 1.73844 8.73843 2.27379 8.45932 2.94762C8.31402 3.29842 8.27467 3.66812 8.25964 4.06996C8.24756 4.39299 8.08454 4.66251 7.84395 4.80141C7.60337 4.94031 7.28845 4.94673 7.00266 4.79568C6.64714 4.60777 6.30729 4.45699 5.93083 4.40743C5.20773 4.31223 4.47642 4.50819 3.89779 4.95219C3.64843 5.14353 3.45827 5.3796 3.28099 5.6434C3.11068 5.89681 2.92517 6.21815 2.70294 6.60307L2.67769 6.64681C2.45545 7.03172 2.26993 7.35304 2.13562 7.62723C1.99581 7.91267 1.88644 8.19539 1.84541 8.50701C1.75021 9.23012 1.94617 9.96142 2.39016 10.5401C2.62128 10.8412 2.92173 11.0602 3.26217 11.2741C3.53595 11.4461 3.68788 11.7221 3.68786 12C3.68785 12.2778 3.53592 12.5538 3.26217 12.7258C2.92169 12.9397 2.62121 13.1587 2.39007 13.4599C1.94607 14.0385 1.75012 14.7698 1.84531 15.4929C1.88634 15.8045 1.99571 16.0873 2.13552 16.3727C2.26983 16.6469 2.45535 16.9682 2.67758 17.3531L2.70284 17.3969C2.92507 17.7818 3.11058 18.1031 3.28089 18.3565C3.45817 18.6203 3.64833 18.8564 3.89769 19.0477C4.47632 19.4917 5.20763 19.6877 5.93073 19.5925C6.30717 19.5429 6.647 19.3922 7.0025 19.2043C7.28833 19.0532 7.60329 19.0596 7.8439 19.1986C8.08452 19.3375 8.24756 19.607 8.25964 19.9301C8.27467 20.3319 8.31403 20.7016 8.45932 21.0524C8.73843 21.7262 9.27379 22.2616 9.94761 22.5407C10.238 22.661 10.5375 22.7076 10.8546 22.7292C11.1592 22.75 11.5303 22.75 11.9747 22.75H12.0252C12.4697 22.75 12.8407 22.75 13.1454 22.7292C13.4625 22.7076 13.762 22.661 14.0524 22.5407C14.7262 22.2616 15.2616 21.7262 15.5407 21.0524C15.686 20.7016 15.7253 20.3319 15.7403 19.93C15.7524 19.607 15.9154 19.3375 16.156 19.1985C16.3966 19.0596 16.7116 19.0532 16.9974 19.2042C17.3529 19.3921 17.6927 19.5429 18.0692 19.5924C18.7923 19.6876 19.5236 19.4917 20.1022 19.0477C20.3516 18.8563 20.5417 18.6203 20.719 18.3565C20.8893 18.1031 21.0748 17.7818 21.297 17.3969L21.3223 17.3531C21.5445 16.9682 21.7301 16.6468 21.8644 16.3726C22.0042 16.0872 22.1135 15.8045 22.1546 15.4929C22.2498 14.7697 22.0538 14.0384 21.6098 13.4598C21.3787 13.1586 21.0782 12.9397 20.7378 12.7258C20.464 12.5538 20.3121 12.2778 20.3121 11.9999C20.3121 11.7221 20.464 11.4462 20.7377 11.2742C21.0783 11.0603 21.3788 10.8414 21.6099 10.5401C22.0539 9.96149 22.2499 9.23019 22.1547 8.50708C22.1136 8.19546 22.0043 7.91274 21.8645 7.6273C21.7302 7.35313 21.5447 7.03183 21.3224 6.64695L21.2972 6.60318C21.0749 6.21825 20.8894 5.89688 20.7191 5.64347C20.5418 5.37967 20.3517 5.1436 20.1023 4.95225C19.5237 4.50826 18.7924 4.3123 18.0692 4.4075C17.6928 4.45706 17.353 4.60782 16.9975 4.79572C16.7117 4.94679 16.3967 4.94036 16.1561 4.80144C15.9155 4.66253 15.7524 4.39297 15.7403 4.06991C15.7253 3.66808 15.686 3.2984 15.5407 2.94762C15.2616 2.27379 14.7262 1.73844 14.0524 1.45933C13.762 1.33905 13.4625 1.29241 13.1454 1.27077C12.8407 1.24999 12.4697 1.24999 12.0252 1.25H11.9747ZM10.5216 2.84515C10.5988 2.81319 10.716 2.78372 10.9567 2.76729C11.2042 2.75041 11.5238 2.75 12 2.75C12.4762 2.75 12.7958 2.75041 13.0432 2.76729C13.284 2.78372 13.4012 2.81319 13.4783 2.84515C13.7846 2.97202 14.028 3.21536 14.1548 3.52165C14.1949 3.61826 14.228 3.76887 14.2414 4.12597C14.271 4.91835 14.68 5.68129 15.4061 6.10048C16.1321 6.51968 16.9974 6.4924 17.6984 6.12188C18.0143 5.9549 18.1614 5.90832 18.265 5.89467C18.5937 5.8514 18.9261 5.94047 19.1891 6.14228C19.2554 6.19312 19.3395 6.27989 19.4741 6.48016C19.6125 6.68603 19.7726 6.9626 20.0107 7.375C20.2488 7.78741 20.4083 8.06438 20.5174 8.28713C20.6235 8.50382 20.6566 8.62007 20.6675 8.70287C20.7108 9.03155 20.6217 9.36397 20.4199 9.62698C20.3562 9.70995 20.2424 9.81399 19.9397 10.0041C19.2684 10.426 18.8122 11.1616 18.8121 11.9999C18.8121 12.8383 19.2683 13.574 19.9397 13.9959C20.2423 14.186 20.3561 14.29 20.4198 14.373C20.6216 14.636 20.7107 14.9684 20.6674 15.2971C20.6565 15.3799 20.6234 15.4961 20.5173 15.7128C20.4082 15.9355 20.2487 16.2125 20.0106 16.6249C19.7725 17.0373 19.6124 17.3139 19.474 17.5198C19.3394 17.72 19.2553 17.8068 19.189 17.8576C18.926 18.0595 18.5936 18.1485 18.2649 18.1053C18.1613 18.0916 18.0142 18.045 17.6983 17.8781C16.9973 17.5075 16.132 17.4803 15.4059 17.8995C14.68 18.3187 14.271 19.0816 14.2414 19.874C14.228 20.2311 14.1949 20.3817 14.1548 20.4784C14.028 20.7846 13.7846 21.028 13.4783 21.1549C13.4012 21.1868 13.284 21.2163 13.0432 21.2327C12.7958 21.2496 12.4762 21.25 12 21.25C11.5238 21.25 11.2042 21.2496 10.9567 21.2327C10.716 21.2163 10.5988 21.1868 10.5216 21.1549C10.2154 21.028 9.97201 20.7846 9.84514 20.4784C9.80512 20.3817 9.77195 20.2311 9.75859 19.874C9.72896 19.0817 9.31997 18.3187 8.5939 17.8995C7.86784 17.4803 7.00262 17.5076 6.30158 17.8781C5.98565 18.0451 5.83863 18.0917 5.73495 18.1053C5.40626 18.1486 5.07385 18.0595 4.81084 17.8577C4.74458 17.8069 4.66045 17.7201 4.52586 17.5198C4.38751 17.314 4.22736 17.0374 3.98926 16.625C3.75115 16.2126 3.59171 15.9356 3.4826 15.7129C3.37646 15.4962 3.34338 15.3799 3.33248 15.2971C3.28921 14.9684 3.37828 14.636 3.5801 14.373C3.64376 14.2901 3.75761 14.186 4.0602 13.9959C4.73158 13.5741 5.18782 12.8384 5.18786 12.0001C5.18791 11.1616 4.73165 10.4259 4.06021 10.004C3.75769 9.81389 3.64385 9.70987 3.58019 9.62691C3.37838 9.3639 3.28931 9.03149 3.33258 8.7028C3.34348 8.62001 3.37656 8.50375 3.4827 8.28707C3.59181 8.06431 3.75125 7.78734 3.98935 7.37493C4.22746 6.96253 4.3876 6.68596 4.52596 6.48009C4.66055 6.27983 4.74468 6.19305 4.81093 6.14222C5.07395 5.9404 5.40636 5.85133 5.73504 5.8946C5.83873 5.90825 5.98576 5.95483 6.30173 6.12184C7.00273 6.49235 7.86791 6.51962 8.59394 6.10045C9.31998 5.68128 9.72896 4.91837 9.75859 4.12602C9.77195 3.76889 9.80512 3.61827 9.84514 3.52165C9.97201 3.21536 10.2154 2.97202 10.5216 2.84515Z"
                                          fill="#ffffff"></path>
                                </g>
                            </svg>
                            {{ __('messages.Настройки') }}
                        </button>


                        <!-- Main modal -->
                        <div id="settings_training" tabindex="-1" aria-hidden="true"
                             class="hidden bg-gray-900/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            {{ __('messages.Настройки') }}
                                        </h3>
                                        <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="settings_training">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form action="{{ route('trainings.settings') }}" method="POST">
                                            @csrf
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                                {{ __('messages.Классификации тренировки') }}
                                            </h4>
                                            <div id="fieldsContainer">
                                                <div class="flex items-center mb-4">
                                                    <input
                                                        type="text"
                                                        name="classification_names[]"
                                                        placeholder="{{ __('messages.Название') }}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-3 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required
                                                    >
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                id="addFieldBtn"
                                                class="mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition"
                                            >
                                                + {{ __('messages.Добавить поле') }}
                                            </button>

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                            >
                                                {{ __('messages.Сохранить') }}
                                            </button>
                                        </form>
                                        <div class="flex flex-wrap gap-2">
                                            @if($trainingClass[0])
                                                @foreach($trainingClass as $key => $class)
                                                    <div id="trainingClass_{{ $class->id }}"
                                                         class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-800 bg-gray-200 rounded-sm dark:bg-gray-600 dark:text-gray-300">
                                                        {{ $class->name }}
                                                        <a href="javascript:void(0)" type="button"
                                                           class="inline-flex items-center p-1 ms-2 text-sm text-gray-400 bg-transparent rounded-xs hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-gray-300"
                                                           data-dismiss-target="#badge-dismiss-dark"
                                                           aria-label="Remove"
                                                           title="{{ __('messages.Удалить классификацию') }}"
                                                           onclick="deleteClassTraining({{ $class->id }})">
                                                            <svg class="w-2 h-2" aria-hidden="true"
                                                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                 viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                      stroke-linejoin="round" stroke-width="2"
                                                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="toast-danger"
                                             class="hidden mt-3 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
                                             role="alert">
                                            <div
                                                class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                                <svg class="w-5 h-5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                                </svg>
                                                <span class="sr-only">Error icon</span>
                                            </div>
                                            <div
                                                class="ms-3 text-sm font-normal">{{ __('messages.Классификация успешно удалена') }}</div>
                                            <button type="button"
                                                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                                                    data-dismiss-target="#toast-danger" aria-label="Close">
                                                <span class="sr-only">Close</span>
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            </button>
                                        </div>

                                        <form class="mt-3" action="{{ route('trainings.addresses') }}" method="POST">
                                            @csrf
                                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                                                {{ __('messages.Адреса тренировок') }}
                                            </h4>
                                            <div id="fieldsContainerAddresses">
                                                <div class="flex items-center mb-4">
                                                    <input
                                                        type="text"
                                                        name="addresses_names[]"
                                                        placeholder="{{ __('messages.Название') }}"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-3 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required
                                                    >
                                                </div>
                                            </div>

                                            <button
                                                type="button"
                                                id="addFieldBtnAddresses"
                                                class="mb-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition"
                                            >
                                                + {{ __('messages.Добавить поле') }}
                                            </button>

                                            <button
                                                type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                            >
                                                {{ __('messages.Сохранить') }}
                                            </button>
                                        </form>
                                        <div class="flex  flex-wrap gap-2">
                                            @if($trainingAddresses[0])
                                                @foreach($trainingAddresses as $key => $addres)
                                                    <div id="trainingAddres_{{ $addres->id }}"
                                                         class="inline-flex items-center px-2 py-1 text-sm font-medium text-gray-800 bg-gray-200 rounded-sm dark:bg-gray-600 dark:text-gray-300">
                                                        {{ $addres->name }}
                                                        <a href="javascript:void(0)" type="button"
                                                           class="inline-flex items-center p-1 ms-2 text-sm text-gray-400 bg-transparent rounded-xs hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-gray-300"
                                                           data-dismiss-target="#badge-dismiss-dark"
                                                           aria-label="Remove"
                                                           title="Удалить адрес"
                                                           onclick="deleteAddressTraining({{ $addres->id }})">
                                                            <svg class="w-2 h-2" aria-hidden="true"
                                                                 xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                 viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round"
                                                                      stroke-linejoin="round" stroke-width="2"
                                                                      d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div id="toast-danger-addres"
                                             class="hidden mt-3 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800"
                                             role="alert">
                                            <div
                                                class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                                <svg class="w-5 h-5" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                     viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                                                </svg>
                                                <span class="sr-only">Error icon</span>
                                            </div>
                                            <div
                                                class="ms-3 text-sm font-normal">{{ __('messages.Адрес успешно удален') }}</div>
                                            <button type="button"
                                                    class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700"
                                                    data-dismiss-target="#toast-danger-addres" aria-label="Close">
                                                <span class="sr-only">Close</span>
                                                <svg class="w-3 h-3" aria-hidden="true"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                          stroke-linejoin="round" stroke-width="2"
                                                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal toggle -->
                        <button data-modal-target="add_team" data-modal-toggle="add_team"
                                class="block text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                type="button">
                            {{ __('messages.Добавить тренировку') }}
                        </button>
                        <!-- Main modal -->
                        <div id="add_team" tabindex="-1" aria-hidden="true"
                             class="hidden bg-gray-900/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                            <div class="relative p-4 w-full max-w-md max-h-full">
                                <!-- Modal content -->
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                    <!-- Modal header -->
                                    <div
                                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                            {{ __('messages.Добавить новую тренировку') }}
                                        </h3>
                                        <button type="button"
                                                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                data-modal-hide="add_team">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="none"
                                                 viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <div class="p-4 md:p-5">
                                        <form class="space-y-4" method="POST" action="{{ route('trainings.store') }}">

                                            @csrf
                                            <input type="hidden" id="user_id" name="user_id"
                                                   value="{{ Auth::user()->id }}"/>
                                            <input type="hidden" id="count_players" name="count_players" value=""/>
                                            <!-- Name -->
                                            <div class="grid grid-cols-2 gap-3">
                                                @if(CountTeam() >= 2)
                                                    <div class="col-span-1 sm:col-span-1">
                                                        <label for="team_code_training"
                                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Команда') }}</label>
                                                        <select id="team_code_training" name="team_code"
                                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                            @foreach($teamActive as $key => $team)
                                                                <option @if($key == 0) selected
                                                                        @endif value="{{ $team->team_code }}"
                                                                        data-count-players="{{ countPlayers($team->team_code) }}">
                                                                    <span class="pt-2">{{ $team->name }}</span>
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                @else
                                                    @foreach($teamActive as $key => $team)
                                                        <input type="hidden" id="team_code_training" name="team_code"
                                                               value="{{ $team->team_code }}"/>
                                                    @endforeach
                                                @endif
                                                <div
                                                    class="@if(CountTeam() >= 2) col-span-1 @else col-span-2 @endif ">
                                                    <label for="class"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Классификация') }}</label>
                                                    <select id="class" name="class"
                                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                                        @if($trainingClass[0])
                                                            @foreach($trainingClass as $key => $class)
                                                                <option @if($key == 0) selected
                                                                        @endif value="{{ $class->id }}">
                                                                    <span class="pt-2">{{ $class->name }}</span>
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            <option selected value="0">
                                                                <span
                                                                    class="pt-2">{{ __('messages.Без классификации') }}</span>
                                                            </option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <label for="date"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ __('messages.Дата') }}
                                                </label>
                                                <div class="relative">
                                                    <div
                                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                             aria-hidden="true"
                                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                             viewBox="0 0 20 20">
                                                            <path
                                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                                        </svg>
                                                    </div>
                                                    <input type="date"
                                                           name="date" id="date"
                                                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                           placeholder="Select date" required>
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="flex items-center space-x-2 mb-4">
                                                    <input type="checkbox" id="repeat_until_checkbox"
                                                           name="repeat_until_checkbox"
                                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                                    <label for="repeat_until_checkbox"
                                                           class="text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Повторять до') }}</label>
                                                    <input type="date" id="repeat_until_date" name="repeat_until_date"
                                                           class="ml-2 p-2 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                           style="display:none;">
                                                </div>

                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="col-1">
                                                    <label for="start"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ __('messages.Время начала') }}
                                                    </label>
                                                    <div class="flex">
                                                        <input type="text" id="start" name="start"
                                                               class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                               required>
                                                        <div
                                                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                                 aria-hidden="true"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 fill="currentColor" viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                      d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                      clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            flatpickr("#start", {
                                                                enableTime: true, // Enable time picker
                                                                noCalendar: true, // Only time selection
                                                                dateFormat: "H:i", // 24-hour format
                                                                time_24hr: true,   // Use 24-hour time picker
                                                                locale: "ru"       // Russian language
                                                            });
                                                        });
                                                    </script>
                                                </div>


                                                <div class="col-1">
                                                    <label for="finish"
                                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ __('messages.Время завершения') }}
                                                    </label>
                                                    <div class="flex">
                                                        <input type="text" id="finish" name="finish"
                                                               class="rounded-none rounded-s-lg bg-gray-50 border text-gray-900 leading-none focus:ring-blue-500 focus:border-blue-500 block flex-1 w-full text-sm border-gray-300 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                               required>
                                                        <div
                                                            class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border rounded-s-0 border-s-0 border-gray-300 rounded-e-md dark:bg-gray-600 dark:text-gray-400 dark:border-gray-600">
                                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                                 aria-hidden="true"
                                                                 xmlns="http://www.w3.org/2000/svg"
                                                                 fill="currentColor" viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                      d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                                                      clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function () {
                                                            flatpickr("#finish", {
                                                                enableTime: true, // Enable time picker
                                                                noCalendar: true, // Only time selection
                                                                dateFormat: "H:i", // 24-hour format
                                                                time_24hr: true,   // Use 24-hour time picker
                                                                locale: "ru"       // Russian language
                                                            });
                                                        });
                                                    </script>
                                                </div>

                                            </div>

                                            @if(checkLoadControl())
                                                <div
                                                    class="flex flex-col items-center rounded-md p-4 shadow-inner select-none"
                                                    style="background: rgb(17 24 39);">
                                                    <h3 class="text-xl mb-3 font-semibold text-gray-900 dark:text-white">
                                                        LOAD
                                                        CONTROL</h3>
                                                    <div class="grid grid-cols-2 gap-3">
                                                        <div class="col-span-2 sm:col-span-1">
                                                            <label for="recovery"
                                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Восстановление') }}</label>
                                                            <input type="number" name="recovery"
                                                                   id="recovery"
                                                                   max="100"
                                                                   min="1"
                                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                            >
                                                        </div>
                                                        <div class="col-span-2 sm:col-span-1">
                                                            <label for="load"
                                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Нагрузка') }}</label>
                                                            <input type="number" name="load"
                                                                   id="load"
                                                                   max="100"
                                                                   min="1"
                                                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div>
                                                <label for="desc"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Описание') }}</label>
                                                <textarea type="text" name="desc"
                                                          id="desc"
                                                          class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                ></textarea>
                                                <x-input-error :messages="$errors->get('desc')" class="mt-2"/>
                                            </div>
                                            <div class="col-span-1 sm:col-span-1">
                                                <label for="link_docs"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Ссылка на документ') }}</label>
                                                <input type="text" name="link_docs"
                                                       id="link_docs"
                                                       class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                >
                                            </div>

                                            <div>
                                                <label for="addresses"
                                                       class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Классификация') }}</label>
                                                <select id="addresses" name="addresses"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                                    @if($trainingAddresses[0])
                                                        @foreach($trainingAddresses as $key => $addres)
                                                            <option @if($key == 0) selected
                                                                    @endif value="{{ $addres->id }}">
                                                                <span class="pt-2">{{ $addres->name }}</span>
                                                            </option>
                                                        @endforeach
                                                    @else
                                                        <option selected value="0">
                                                                <span
                                                                    class="pt-2">{{ __('messages.Без адреса') }}</span>
                                                        </option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="grid grid-cols-2 gap-3">
                                                <div class="col-span-2 sm:col-span-1">
                                                    <x-checkbox name="active"
                                                                id="active"
                                                                checked>
                                                        {{ __('messages.Активный') }}
                                                    </x-checkbox>
                                                    <label
                                                        class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                                                        for="active">{{ __('messages.Активный') }}</label>
                                                </div>
                                            </div>
                                            <button type="button" id="button_save_training"
                                                    class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                {{ __('messages.Добавить тренировку') }}</button>
                                            <div id="response"></div>
                                        </form>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <button id="btn_team_success" data-modal-target="add_team_success"
                                    data-modal-toggle="add_team_success"
                                    class="hidden" type="button"></button>
                            <div id="add_team_success" tabindex="-1" aria-hidden="true"
                                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div id="alert-border-3"
                                     class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                                     role="alert">
                                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg"
                                         fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                    </svg>
                                    <div class="ms-3 text-sm font-medium">
                                        {{ __('messages.Тренировка создана') }}
                                    </div>
                                    <button type="button"
                                            class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                                            data-dismiss-target="#alert-border-3" aria-label="Close">
                                        <span class="sr-only">Dismiss</span>
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none"
                                             viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    @else
                        <div
                            class="flex items-center p-4 text-sm text-gray-800 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"
                            role="alert">
                            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            <div class="flex flex-col gap-3 items-center sm:flex-row">
                                {{ __('messages.Чтобы добавить тренировку, вам необходимо создать команду.') }}
                                @if(Auth::user()->role == 'coach' || Auth::user()->role == 'admin')
                                    <a href="{{ route('teams.index') }}"
                                       class="ml-3 text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-2 py-1 text-center dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                        {{ __('messages.Мои команды') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div
                        class="flex w-full">
                        @include('trainings.partial.calendar')
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
@else
    <x-app-layout>
        <x-slot name="header">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('messages.Тренировки') }}
                </h2>
            </div>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative grid grid-cols-1 sm:grid-cols-4 gap-5 p-6 text-gray-900 dark:text-gray-100">

                        @if(trainingTodayForPlayer() == false)
                            <div class="col-span-1 sm:col-span-1">
                                <div
                                    class="flex flex-col h-full relative bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6 border-2 border-green-900">
                                    <span
                                        class="mb-3">{{ __('messages.На сегодня тренировок не запланировано') }}</span>
                                </div>
                            </div>
                        @endif
                        @foreach($trainingForPlayer as $training)
                            <div
                                class="flex flex-col justify-between relative h-full col-span-1 sm:col-span-1 select-none bg-white dark:bg-gray-900 shadow-lg rounded-lg p-6 @if($training->date == date('Y-m-d')) border-2 border-green-900 @elseif($training->active != true) border-2 border-gray-500 @endif">
                                @if($training->active == true)

                                    @if($training->date == date('Y-m-d'))

                                        @if($training->confirmed != true)
                                            <span
                                                class="inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300 absolute -translate-y-1/2 translate-x-1/1 left-auto top-0 -right-1">
                                        <span class="w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                                        {{ __('messages.Сегодня') }}
                                    </span>
                                        @else
                                            <span
                                                class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300 absolute -translate-y-1/2 translate-x-1/1 left-auto top-0 -right-1">
                                            <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                            {{ __('messages.Проведена') }}
                                    </span>
                                        @endif
                                    @else
                                        @if($training->confirmed == true)
                                            <span
                                                class="inline-flex items-center bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300 absolute -translate-y-1/2 translate-x-1/1 left-auto top-0 -right-1">
                                            <span class="w-2 h-2 me-1 bg-yellow-500 rounded-full"></span>
                                            {{ __('messages.Проведена') }}
                                    </span>
                                        @endif
                                    @endif
                                @else
                                    <span
                                        class="inline-flex items-center bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-gray-700 dark:text-gray-300 absolute -translate-y-1/2 translate-x-1/1 left-auto top-0 -right-1">
                                            <span class="w-2 h-2 me-1 bg-gray-500 rounded-full"></span>
                                            {{ __('messages.Отменена') }}
                                    </span>
                                @endif
                                <div class="flex">
                                    <div class="flex flex-col justify-between w-full relative">
                                        <div class="flex flex-col">
                                            <div class="flex justify-between gap-3">
                                                <div class=" text-gray-500 text-sm font-bold">
                                                    {{ timeFormatHI($training->start) }}
                                                </div>
                                                <div class=" text-gray-500 text-sm font-bold">
                                                    {{ timeTo($training->start,$training->finish) }} <span>{{ __('messages.мин.') }}</span>
                                                </div>
                                                <div class=" text-gray-500 text-sm font-bold">
                                                    {{ timeFormatHI($training->finish) }}
                                                </div>
                                            </div>
                                            <div class="flex mb-3 items-center space-x-4">
                                                <div
                                                    class="p-2 px-2.5 bg-indigo-200 text-indigo-600 rounded-full  font-bold">
                                                    {{ dayOfDate($training->date) }}
                                                </div>
                                                <div>
                                                    <div
                                                        class="text-gray-600 text-sm">{{ nameClass($training->class) }}</div>
                                                    <div class="text-gray-300 text-2xl font-semibold">
                                                        {{ dateFormatDM($training->date) }}
                                                        @if(checkLoadControl())
                                                            <div class="flex gap-3">
                                                                @if($training->recovery)
                                                                    <div
                                                                        class="text-green-500 text-sm font-medium flex items-center">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             class="h-4 w-4 mr-1"
                                                                             fill="none" viewBox="0 0 24 24"
                                                                             stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  d="M5 15l7-7 7 7"/>
                                                                        </svg>
                                                                        {{ $training->recovery }}
                                                                    </div>
                                                                @endif
                                                                @if($training->load)
                                                                    <div
                                                                        class="text-red-500 text-sm font-medium flex items-center ">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             class="h-4 w-4 mr-1"
                                                                             fill="none" viewBox="0 0 24 24"
                                                                             stroke="currentColor" stroke-width="2">
                                                                            <path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  d="M5 15l7-7 7 7"/>
                                                                        </svg>
                                                                        {{ $training->load }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div
                                    class="flex justify-between items-center text-sm text-blue-600 dark:text-blue-500 ">
                                    <div class="flex flex-col text-sm text-gray-400">
                                        <div>{{ playerTeam($training->team_code) }}</div>
                                        @if(presenceCheck($training->id) != 0)
                                            <div class="flex gap-2 text-gray-500">
                                                <div>{{ __('messages.Явка') }}:</div>
                                                <div class="font-bold">{{ presence($training->id) }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>

                        @endforeach
                        <!-- component -->

                    </div>

                </div>
            </div>
        </div>
    </x-app-layout>
@endif
