<!-- Modal overlay -->
<div id="subscriptionModal" tabindex="-1" aria-hidden="true"
     class="hidden bg-gray-900/80 overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class=" w-full max-w-lg p-4">

        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow-lg border border-gray-700">
            <button type="button"
                    class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="subscriptionModal">
                <svg class="w-3 h-3" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">{{ __('messages.Закрыть окно') }}</span>
            </button>

            <div class="p-6" id="subscription-form-container">
                <h2 class="text-2xl font-bold text-white mb-4">{{ __('messages.Заказать подписку') }}</h2>

                <form id="subscription-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="smart-token" id="smart-token" value="">

                    <div>
                        <label class="block text-gray-300 mb-1">{{ __('messages.Имя') }} <span class="text-red-400">*</span></label>
                        <input type="text" name="name" class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">{{ __('messages.Телефон') }} <span class="text-red-400">*</span></label>
                        <input type="tel" name="phone" class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-gray-300 mb-1">{{ __('messages.Выберите подписку') }} <span class="text-red-400">*</span></label>
                        <select name="subscription_type" class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500" required>
                            <option value="">-- {{ __('messages.Выбрать') }} --</option>
                            <option value="Минимум">FREE</option>
                            <option value="{{ __('messages.Стандарт') }}">{{ __('messages.Стандарт') }}</option>
                            <option value="Enterprise">Enterprise</option>
                        </select>
                    </div>

                    <div>
                        <span class="block text-gray-300 mb-1">{{ __('messages.Тип клиента') }} <span class="text-red-400">*</span></span>
                        <div class="grid grid-cols-2 gap-3 mt-1">
                            <label class="block cursor-pointer subscription-radio-label">
                                <input type="radio" name="customer_type" value="individual" class="hidden peer" checked>
                                <div class="p-4 bg-gray-700 border border-gray-600 rounded-lg text-center text-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-700 peer-checked:text-white">{{ __('messages.Физ. лицо') }}</div>
                            </label>
                            <label class="block cursor-pointer subscription-radio-label">
                                <input type="radio" name="customer_type" value="company" class="hidden peer">
                                <div class="p-4 bg-gray-700 border border-gray-600 rounded-lg text-center text-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-700 peer-checked:text-white">{{ __('messages.Юр. лицо') }}</div>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center text-gray-300">
                            <input type="checkbox" name="policy_accepted" class="mr-2" checked>
                            <div class="text-xs text-gray-400 mt-2">
                                {!! __('messages.Оформляя заказ, Вы соглашаетесь с Офертой и Политикой.') !!}
                            </div>
                        </label>
                    </div>

                    <div id="smart-captcha-container" class="smart-captcha" data-sitekey="{{ config('services.yandex_smart_captcha.client_key') }}" data-callback="onSubscriptionCaptchaSuccess"></div>
                    <div id="smart-captcha-error" class="hidden text-red-400 text-sm mt-1"></div>
                    @if(empty(config('services.yandex_smart_captcha.client_key')))
                    <p class="text-amber-400 text-sm mt-1">{{ __('messages.Капча не настроена. Укажите YANDEX_SMART_CAPTCHA_CLIENT_KEY в .env') }}</p>
                    @endif

                    <button type="submit" id="submit-btn" class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                        {{ __('messages.Отправить заявку') }}
                    </button>
                </form>
            </div>

            <div id="success-message" class="hidden mb-6 p-3 text-white text-center">
                ✅ {{ __('messages.Заявка успешно отправлена! Инструкции на почте.') }}
            </div>

            <div id="loader" role="status" class="hidden w-full flex justify-center mb-6 p-3">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<script>
    window.onSubscriptionCaptchaSuccess = function(token) {
        document.getElementById('smart-token').value = token;
        var errEl = document.getElementById('smart-captcha-error');
        if (errEl) { errEl.classList.add('hidden'); errEl.textContent = ''; }
    };
</script>
{{-- Yandex Smart Captcha: скрипт ищет все элементы с классом smart-captcha и рендерит виджет. Загружаем при открытии модалки, чтобы контейнер был виден. --}}
<script>
    (function() {
        var clientKey = @json(config('services.yandex_smart_captcha.client_key'));
        if (!clientKey) return;

        function loadSmartCaptchaScript() {
            if (window.__subscriptionCaptchaScriptLoaded) return;
            if (document.querySelector('script[src*="smartcaptcha.yandexcloud.net/captcha.js"]')) {
                window.__subscriptionCaptchaScriptLoaded = true;
                return;
            }
            window.__subscriptionCaptchaScriptLoaded = true;
            var script = document.createElement('script');
            script.src = 'https://smartcaptcha.yandexcloud.net/captcha.js';
            script.defer = true;
            document.head.appendChild(script);
        }

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById('subscriptionModal');
            if (!modal) return;

            var observer = new MutationObserver(function() {
                if (!modal.classList.contains('hidden')) loadSmartCaptchaScript();
            });
            observer.observe(modal, { attributes: true, attributeFilter: ['class'] });

            document.body.addEventListener('click', function(e) {
                if (e.target && (e.target.getAttribute('data-modal-toggle') === 'subscriptionModal' || e.target.closest('[data-modal-toggle="subscriptionModal"]'))) {
                    setTimeout(loadSmartCaptchaScript, 100);
                }
            }, true);

            if (!modal.classList.contains('hidden')) loadSmartCaptchaScript();
        });
    })();
</script>
<script>
    @php
        $subI18n = [
            'sending' => __('messages.Отправка...'),
            'errorSend' => __('messages.Ошибка при отправке'),
            'errorGeneric' => __('messages.Произошла ошибка'),
        ];
    @endphp
    window.__subI18n = @json($subI18n);
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('subscription-form');
        const submitBtn = document.getElementById('submit-btn');
        const formContainer = document.getElementById('subscription-form-container');
        const loader = document.getElementById('loader');
        const successMessage = document.getElementById('success-message');
        const modalElement = document.getElementById('subscriptionModal');

        // Попытка инициализировать Modal Flowbite
        let flowbiteModal = null;
        if (typeof Modal !== 'undefined') {
            flowbiteModal = new Modal(modalElement);
        }

        let recaptchaReady = false;

        function checkSmartCaptchaToken() {
            var tokenEl = document.getElementById('smart-token');
            return tokenEl && tokenEl.value && tokenEl.value.length > 0;
        }

        function showSmartCaptchaError(msg) {
            var errEl = document.getElementById('smart-captcha-error');
            if (errEl) { errEl.textContent = msg || '{{ __("messages.Решите капчу") }}'; errEl.classList.remove('hidden'); }
        }

        function initRecaptcha() {
            return true;
        }

        async function generateRecaptchaToken() {
            return null;
        }

        if (!initRecaptcha()) {
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.textContent = window.__subI18n.sending;

            formContainer.classList.add('hidden');
            loader.classList.remove('hidden');

            try {
                if (!checkSmartCaptchaToken()) {
                    loader.classList.add('hidden');
                    formContainer.classList.remove('hidden');
                    showSmartCaptchaError();
                    return;
                }

                const formData = new FormData(form);
                const response = await fetch('{{ route("subscription-order.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': formData.get('_token')
                    }
                });

                const contentType = response.headers.get('Content-Type') || '';
                let result;
                try {
                    result = await response.json();
                } catch (parseErr) {
                    const text = await response.text();
                    console.error('Subscription order: server returned non-JSON', response.status, text.slice(0, 500));
                    loader.classList.add('hidden');
                    formContainer.classList.remove('hidden');
                    if (response.status === 419) {
                        alert('❌ Сессия истекла. Обновите страницу и попробуйте снова.');
                    } else {
                        alert('❌ ' + window.__subI18n.errorGeneric + ' (код ' + response.status + '). Обновите страницу или попробуйте позже.');
                    }
                    return;
                }

                loader.classList.add('hidden');

                if (result.success) {
                    successMessage.classList.remove('hidden');
                    form.reset();
                    document.getElementById('smart-token').value = '';

                    setTimeout(() => {
                        var closeBtn = document.querySelector('[data-modal-hide="subscriptionModal"]');
                        if (closeBtn) closeBtn.click();
                        if (flowbiteModal && typeof flowbiteModal.hide === 'function') {
                            try { flowbiteModal.hide(); } catch (e) {}
                        }
                        modalElement.classList.add('hidden');
                        modalElement.setAttribute('aria-hidden', 'true');
                        document.body.classList.remove('overflow-hidden');
                        document.documentElement.classList.remove('overflow-hidden');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                        document.querySelectorAll('.modal-backdrop, [modal-backdrop]').forEach(function(el) { el.remove(); });
                        successMessage.classList.add('hidden');
                        formContainer.classList.remove('hidden');
                    }, 2000);

                } else {
                    alert('❌ ' + (result.message || window.__subI18n.errorSend));
                    formContainer.classList.remove('hidden');
                }
            } catch (error) {
                const url = '{{ route("subscription-order.store") }}';
                console.error('Subscription order request failed', {
                    url,
                    name: error.name,
                    message: error.message,
                    error
                });
                loader.classList.add('hidden');
                formContainer.classList.remove('hidden');
                alert('❌ ' + window.__subI18n.errorGeneric + ' Проверьте интернет-соединение и попробуйте снова. (Подробности в консоли: F12 → Console)');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            }
        });
    });
</script>

<style>
    /* Yandex Smart Captcha: контейнеру нужна высота для отображения виджета */
    #smart-captcha-container.smart-captcha {
        min-height: 100px;
    }
    /* Убираем лишние звёздочки: у кнопок выбора типа клиента не должно быть ::after/::before от глобальных стилей */
    #subscription-form .subscription-radio-label::after,
    #subscription-form .subscription-radio-label::before {
        content: none !important;
        display: none !important;
    }
</style>
