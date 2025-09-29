@props([
    'text' => 'Название функции',
    'description' => 'Описание отсутствует',
    'popoverId' => 'popover-' . \Illuminate\Support\Str::uuid(),
    'iconType' => 'check',
])

<li class="flex items-center space-x-3">
    <!-- Icon -->
    @if($iconType === 'check')
        {{-- Green check icon --}}
        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor"
             viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                  clip-rule="evenodd"></path>
        </svg>
    @elseif($iconType === 'cross')
        {{-- Red cross icon --}}
        <svg class="flex-shrink-0 w-5 h-5" stroke="#c01111" fill="#c01111"
             viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M14.348 5.652a1 1 0 0 0-1.414 0L10 8.586 7.066 5.652a1 1 0 0 0-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 0 0 1.414 1.414L10 11.414l2.934 2.934a1 1 0 0 0 1.414-1.414L11.414 10l2.934-2.934a1 1 0 0 0 0-1.414z">
            </path>
        </svg>
    @elseif($iconType === 'new')
        <svg class="flex-shrink-0 w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
             stroke="#ffffff">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M1 12C1 6.47715 5.47715 2 11 2C16.3868 2 20.7788 6.25933 20.9919 11.5939L22.2929 10.2929C22.6834 9.90237 23.3166 9.90237 23.7071 10.2929C24.0976 10.6834 24.0976 11.3166 23.7071 11.7071L20.7071 14.7071C20.5196 14.8946 20.2652 15 20 15C19.7348 15 19.4804 14.8946 19.2929 14.7071L16.2929 11.7071C15.9024 11.3166 15.9024 10.6834 16.2929 10.2929C16.6834 9.90237 17.3166 9.90237 17.7071 10.2929L18.9889 11.5747C18.7678 7.35413 15.2756 4 11 4C6.58172 4 3 7.58172 3 12C3 16.4183 6.58172 20 11 20C13.5127 20 15.7544 18.8427 17.2226 17.0283C17.57 16.599 18.1997 16.5326 18.629 16.88C19.0584 17.2274 19.1248 17.8571 18.7774 18.2864C16.9457 20.5499 14.1418 22 11 22C5.47715 22 1 17.5228 1 12ZM12 6C12 5.44772 11.5523 5 11 5C10.4477 5 10 5.44772 10 6V12C10 12.2652 10.1054 12.5196 10.2929 12.7071L13.2929 15.7071C13.6834 16.0976 14.3166 16.0976 14.7071 15.7071C15.0976 15.3166 15.0976 14.6834 14.7071 14.2929L12 11.5858V6Z"
                      fill="#fdaf08"></path>
            </g>
        </svg>
    @endif

    <!-- Text & Info Button -->
    <p>
        {{ $text }}
        <button data-popover-target="{{ $popoverId }}" data-popover-placement="bottom-end" type="button">
            <svg class="w-4 h-4 ms-2 text-gray-400 hover:text-gray-500" aria-hidden="true" fill="currentColor"
                 viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                      clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Показать дополнительно</span>
        </button>
    </p>

    <!-- Popover -->
    <div data-popover id="{{ $popoverId }}" role="tooltip"
         class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-xs opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
        <div class="p-3 space-y-2">
            <h3 class="font-semibold text-gray-900 dark:text-white">Описание</h3>
            <p>{!! $description !!}</p>
        </div>
        <div data-popper-arrow></div>
    </div>
</li>
