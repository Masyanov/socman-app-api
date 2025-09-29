<x-app-layout>
    <x-slot name="header">
        <div class="flex gap-3 items-center justify-between flex-col sm:flex-row">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('messages.Дашборд') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-2.5 mb-3 dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @php
                    $role = Auth::user()->role;
                @endphp

                @if($role === 'admin')
                    @include('dashboard.admin')
                @elseif($role === 'coach')
                    @include('dashboard.coach')
                @elseif($role === 'player')
                    @include('dashboard.player')
                @elseif($role === 'super-admin')
                    @include('dashboard.super-admin')
                @else
                    <p>Нет доступа или дефолтный контент</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
