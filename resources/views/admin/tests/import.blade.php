<div class="w-full py-8">

    @if (session('success'))
        <div
            class="flex items-center p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.03 4.165a1 1 0 1 1 1.94 0l-.54 2.872a.5.5 0 0 0 .193.571l2.426 1.838a1 1 0 1 1-1.218 1.583l-2.426-1.838a.5.5 0 0 0-.641.002l-2.426 1.838a1 1 0 1 1-1.218-1.583l2.426-1.838a.5.5 0 0 0 .193-.571L9.03 4.165Z"/>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">{{ __('messages.Успех!') }}</span> {{ session('success') }}
            </div>
        </div>
    @endif
    @if (session('error'))
        <div
            class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.03 4.165a1 1 0 1 1 1.94 0l-.54 2.872a.5.5 0 0 0 .193.571l2.426 1.838a1 1 0 1 1-1.218 1.583l-2.426-1.838a.5.5 0 0 0-.641.002l-2.426 1.838a1 1 0 1 1-1.218-1.583l2.426-1.838a.5.5 0 0 0 .193-.571L9.03 4.165Z"/>
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">{{ __('messages.Ошибка!') }}</span> {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Вывод ошибок валидации -->
    @if ($errors->any())
        <div
            class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                 fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.03 4.165a1 1 0 1 1 1.94 0l-.54 2.872a.5.5 0 0 0 .193.571l2.426 1.838a1 1 0 1 1-1.218 1.583l-2.426-1.838a.5.5 0 0 0-.641.002l-2.426 1.838a1 1 0 1 1-1.218-1.583l2.426-1.838a.5.5 0 0 0 .193-.571L9.03 4.165Z"/>
            </svg>
            <span class="sr-only">Danger</span>
            <div>
                <span class="font-medium">{{ __('messages.Ошибки валидации:') }}</span>
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-gray-800 p-6 rounded-lg shadow-md border border-gray-700">

        <form action="{{ route('admin.tests.import.store') }}" method="POST" enctype="multipart/form-data" class="flex gap-3 items-center">
            @csrf
            <div> {{-- Отступ для элемента формы --}}
                <label for="file" class="block mb-2 text-sm font-medium text-white">{{ __('messages.Выберите XLSX файл для загрузки') }}</label>
                <input type="file" name="file" id="file"
                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                       required>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">{{ __('messages.Только XLSX файлы.') }}</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                @include('admin.tests.export')
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                    </svg>
                    Импортировать
                </button>
            </div>
        </form>
    </div>
</div>
@include('admin.tests.results')
