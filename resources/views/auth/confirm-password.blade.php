<x-guest-layout>
    <div class="container  mx-auto flex flex-col bg-gray-100 dark:bg-gray-900" style="margin-top: 100px;">
        <div
            class="min-w-2xs flex flex-col mx-auto p-4 md:justify-between">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.Это безопасная область приложения. Пожалуйста, подтвердите свой пароль, прежде чем продолжить.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('messages.Пароль')"/>

                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        {{ __('messages.Подтвердить') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
