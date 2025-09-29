<x-guest-layout>
    <div class="container  mx-auto flex flex-col bg-gray-100 dark:bg-gray-900" style="margin-top: 100px;">
        <div
            class="min-w-2xs flex flex-col mx-auto p-4 md:justify-between">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам ссылку для сброса пароля, которая позволит вам выбрать новый.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')"/>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                                  required autofocus/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('messages.Ссылка для сброса пароля') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>

</x-guest-layout>
