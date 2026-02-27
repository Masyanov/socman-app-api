<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('messages.Информация обо мне') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("messages.Здесь можно изменить свои данные.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
          class="relative">
        <!-- Modal header -->
        @csrf
        @method('patch')

        <!-- Modal body -->
        <div class="pt-6 space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="grid grid-cols-3 gap-6">
                    <input type="hidden" id="player_id"
                           name="player_id"
                           value="{{ $user->id }}"/>
                    <div class="flex flex-col col-span-3 sm:col-span-1">
                        <label for="avatar"
                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Фото') }}</label>

                        @php
                            $avatarPath = $user->meta->avatar ? "/avatars/{$user->meta->avatar}" : "/images/default-avatar.jpg";
                        @endphp

                        <img id="avatarPreview"
                             class="w-full h-60 rounded-lg object-cover mb-3 border dark:border-gray-500"
                             src="{{ $avatarPath }}"
                             alt="{{ $user->last_name }} {{ $user->name }}">

                        <input
                            class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            name="avatar"
                            id="avatar"
                            type="file"
                            accept="image/*">

                        <x-input-error :messages="$errors->get('avatar')" class="mt-2"/>
                    </div>
                    <script>
                        document.getElementById('avatar').addEventListener('change', function (event) {
                            const [file] = this.files;
                            if (file) {
                                const reader = new FileReader();
                                reader.onload = function (e) {
                                    const preview = document.getElementById('avatarPreview');
                                    preview.src = e.target.result;
                                    preview.classList.remove('object-contain');
                                    preview.classList.add('object-cover'); // меняем стиль, если нужно
                                };
                                reader.readAsDataURL(file);
                            }
                        });
                    </script>
                    <div class=" flex flex-col gap-4 col-span-3 sm:col-span-2">
                        <div class="col-span-1 sm:col-span-1">
                            <label for="last_name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Фамилия') }}</label>
                            <input type="text"
                                   name="last_name"
                                   id="last_name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required value="{{ $user->last_name }}">
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2"/>
                        </div>
                        <div class="col-span-1 sm:col-span-1">
                            <label for="name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Имя') }}</label>
                            <input type="text" name="name"
                                   id="name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required value="{{ $user->name }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-2"/>
                        </div>

                        <div class="col-span-1 sm:col-span-1">
                            <label for="second_name"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Отчество') }}</label>
                            <input type="text" name="second_name"
                                   id="second_name"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->second_name }}">
                            <x-input-error :messages="$errors->get('second_name')" class="mt-2"/>
                        </div>
                        <div class="col-span-1 sm:col-span-1">
                            <label for="birthday"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Дата рождения') }}</label>
                            <input type="date" name="birthday"
                                   id="birthday"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required value="{{ $user->meta->birthday }}">
                            <x-input-error :messages="$errors->get('birthday')" class="mt-2"/>
                        </div>
                        <div class="col-span-1 sm:col-span-1">
                            <label for="email"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email"
                                   id="email"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   required value="{{ $user->email }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2"/>
                        </div>
                    </div>

                </div>
                @if(Auth::user()->role != 'coach')
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2 sm:col-span-1">
                            <label for="tel"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон') }}</label>
                            <input type="tel" name="tel"
                                   id="tel"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->meta->tel ?? 'None'  }}">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="position"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Позиция') }}</label>
                            <input type="text" name="position"
                                   id="position"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->meta->position ?? 'None'  }}">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="number"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Номер') }}</label>
                            <input type="number" name="number"
                                   id="number"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->meta->number ?? 'None'  }}">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="tel_mother"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон матери') }}</label>
                            <input type="tel" name="tel_mother"
                                   id="tel_mother"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->meta->tel_mother ?? 'None'  }}">
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="tel_father"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Телефон отца') }}</label>
                            <input type="tel" name="tel_father"
                                   id="tel_father"
                                   class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ $user->meta->tel_father ?? 'None'  }}">
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                            <label for="comment"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('messages.Комментарий') }}</label>
                            <textarea type="text" name="comment"
                                      id="comment"
                                      class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                      value="{{ $user->meta->comment ?? 'None'  }}">{{ $user->meta->comment ?? 'None'  }}</textarea>
                        </div>

                    </div>
                @endif
            </div>

        </div>
        <!-- Modal footer -->
        <div
            class="mt-3 flex items-center space-x-3 rtl:space-x-reverse">
            <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                {{ __('messages.Сохранить') }}
            </button>
            @if(Auth::user()->role == 'admin')
            <div class="flex">
                <x-checkbox name="active"
                            id="active"
                            :checked="$user->active">
                    {{ __('messages.Активный') }}
                </x-checkbox>
                <label
                    class="ml-2 font-medium text-sm text-gray-700 dark:text-gray-300"
                    for="active">{{ __('messages.Активный') }}</label>
            </div>
            @endif
        </div>
    </form>
</section>
