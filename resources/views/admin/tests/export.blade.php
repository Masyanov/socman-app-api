<a href="{{ route('export.testing_form', ['teamCode' => $team->team_code]) }}"
   class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
    <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
         viewBox="0 0 20 20">
        {{-- Новая иконка: стрелка вниз, указывающая на горизонтальную линию --}}
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M10 4v11m0 0L7 12m3 3 3-3M5 15h10"/>
    </svg>
    Скачать бланк тестирования (XLSX)
</a>

