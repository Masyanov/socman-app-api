<x-guest-layout>
    <div class="container mx-auto flex flex-col bg-gray-100 dark:bg-gray-900" style="margin-top: 100px;">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')"/>
        <div
            class="min-w-2xs flex flex-col mx-auto p-4 md:justify-between">
            <h2 class="text-2xl mb-6 font-medium text-gray-900 dark:text-gray-100">
                {{ __('messages.Авторизация') }}
            </h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autofocus autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('messages.Пароль')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                               class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                               name="remember">
                        <span
                            class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.Запомнить меня') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    @if (Route::has('login'))
                        <a href="{{ route('register') }}"
                           class="ml-4 mr-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white ">
                            {{ __('messages.Регистрация') }}
                        </a>
                    @endif
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                           href="{{ route('password.request') }}">
                            {{ __('messages.Забыли пароль?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-3">
                        {{ __('messages.Войти') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

