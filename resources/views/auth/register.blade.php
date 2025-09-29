<x-guest-layout>
    <div class="container  mx-auto flex flex-col bg-gray-100 dark:bg-gray-900" style="margin-top: 100px;">
        <div
            class="min-w-2xs flex flex-col mx-auto p-4 md:justify-between">
            <h2 class="text-2xl mb-6 font-medium text-gray-900 dark:text-gray-100">
                {{ __('messages.Регистрация') }}
            </h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <input type="hidden" name="ref" value="{{ request('ref') }}">
                <!-- Name -->

                <div>
                    <x-input-label for="name" :value="__('messages.Имя')"/>
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                                  required
                                  autofocus autocomplete="name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                </div>
                <!-- Last Name -->
                <div class="mt-4">
                    <x-input-label for="last_name" :value="__('messages.Фамилия')"/>
                    <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name"
                                  :value="old('last_name')" required autocomplete="last_name"/>
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                </div>
                <!-- Role -->
                <div class="mt-4">
                    <x-input-label for="role" :value="__('messages.Роль')"/>

                    <ul class="grid w-full mt-1 gap-6 md:grid-cols-2">
                        <li>
                            <input type="radio" id="player" name="role" value="player" class="hidden peer role" required
                                   checked/>
                            <label for="player"
                                   class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">{{ __('messages.Игрок') }}</div>
                                    <div class="w-full"
                                         style="font-size: 12px;">{{ __('messages.Регистрация как игрок') }}</div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </label>
                        </li>
                        <li>
                            <input type="radio" id="coach" name="role" value="coach" class="hidden peer role">
                            <label for="coach"
                                   class="inline-flex items-center justify-between w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="block">
                                    <div class="w-full text-lg font-semibold">{{ __('messages.Тренер') }}</div>
                                    <div class="w-full"
                                         style="font-size: 12px;">{{ __('messages.Регистрация как тренер') }}</div>
                                </div>
                                <svg class="w-5 h-5 ms-3 rtl:rotate-180" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                </svg>
                            </label>
                        </li>
                        <x-input-error :messages="$errors->get('role')" class="mt-2"/>
                    </ul>

                </div>

                <!-- Team Code -->
                <div class="mt-4" id="code_field">
                    <x-input-label for="team_code" :value="__('messages.Код команды')"/>
                    <x-text-input id="team_code" class="block mt-1 w-full team_code" type="text" name="team_code"
                                  :value="old('team_code')" autocomplete="team_code" placeholder="999-999" required/>
                    <x-input-error :messages="$errors->get('team_code')" class="mt-2"/>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required
                                  autocomplete="username"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('messages.Пароль')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('messages.Подтверждение пароля')"/>

                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                       href="{{ route('login') }}">
                        {{ __('messages.Уже зарегистрированы?') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('messages.Регистрация') }}
                    </x-primary-button>
                </div>
            </form>
            <div class="w-full mt-6 flex flex-col align-items-center justify-center">
                <h2 class="text-2xl mb-6 font-medium text-gray-900 dark:text-gray-100" style="width: 300px">
                    Вы можете использовать телеграм бот для регистрации
                </h2>
                <a href="https://t.me/load_control_bot" target="_blank" class="mb-6 text-gray-900 dark:text-gray-100">Перейти в бот</a>
                <img width="300" src="/images/img.png" alt="Телеграм бот - Load Control">
            </div>

        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
    <script>
        grecaptcha.ready(function () {
            grecaptcha.execute('{{ config('services.recaptcha.site_key') }}', {action: 'register'}).then(function (token) {
                if (document.getElementById('g-recaptcha-response')) {
                    document.getElementById('g-recaptcha-response').value = token;
                }
            });
        });
    </script>
</x-guest-layout>

