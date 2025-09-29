<div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings"
     role="tabpanel"
     aria-labelledby="settings-tab">

    <div class="relative overflow-x-auto">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Имя
                </th>
                @foreach($dates as $date)
                <th scope="col"
                    class="w-40 px-6 py-3 text-center">{{  dateFormatDM($date) }}</th>
                @endforeach
                <th scope="col" class="w-40 px-6 py-3 text-center">
                    Среднее
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
                @foreach($dates as $date)
                <td class="px-4 py-2">
                    <div class="flex">
                        <div
                            class="w-full min-w-10 flex justify-end bg-gray-200 h-6 dark:bg-gray-700 relative rounded-l">
                            <div
                                class="bg-indigo-600 h-6 dark:bg-indigo-500 rounded-l"
                                style="width: {{ $answers[$date]['recovery'] ?? '0' }}%">
                                <div
                                    class="absolute min-w-10 bottom-0.5 right-0 text-center w-full">{{ $answers[$date]['recovery'] ?? '0' }}
                                    %
                                </div>
                            </div>
                        </div>
                        <div
                            class="w-full min-w-10 bg-gray-200 h-6 dark:bg-gray-700 relative rounded-r">
                            <div
                                class="bg-rose-800 h-6 dark:bg-rose-800 rounded-r"
                                style="width: {{ $answers[$date]['load'] ?? '0' }}%">
                                <div
                                    class="absolute min-w-10 bottom-0.5 text-center w-full">{{ $answers[$date]['load'] ?? '0' }}
                                    %
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                @endforeach
                <?php
                $totalRecovery = 0;
                $countRecovery = 0;

                $totalLoad = 0;
                $countLoad = 0;

                foreach ($answers as $date => $data) {
                    if (isset($data['recovery']) && $data['recovery'] != 0) {
                        $totalRecovery += $data['recovery'];
                        $countRecovery++;
                    }
                    if (isset($data['load']) && $data['load'] != 0) {
                        $totalLoad += $data['load'];
                        $countLoad++;
                    }
                }

                $averageRecovery = ($countRecovery > 0) ? ($totalRecovery / $countRecovery) : 0;
                $averageLoad = ($countLoad > 0) ? ($totalLoad / $countLoad) : 0;

                ?>
                <td class="px-4 py-2 bg-gray-700 dark:bg-gray-700">
                    <div class="flex">
                        <div
                            class="w-full  min-w-10 flex justify-end bg-gray-200 h-6 bg-gray-800 relative rounded-l">
                            <div
                                class="bg-indigo-600 h-6 dark:bg-indigo-500 rounded-l"
                                style="width: {{ $averageRecovery ?? '0' }}%">
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
</div>
