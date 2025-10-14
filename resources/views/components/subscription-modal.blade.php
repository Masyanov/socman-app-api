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
                <h2 class="text-2xl font-bold text-white mb-4">Заказать подписку</h2>

                <!-- Form -->
                <form id="subscription-form" class="space-y-4">
                    @csrf
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                    <!-- Имя -->
                    <div>
                        <label class="block text-gray-300 mb-1">Имя</label>
                        <input type="text" name="name"
                               class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Телефон -->
                    <div>
                        <label class="block text-gray-300 mb-1">Телефон</label>
                        <input type="tel" name="phone"
                               class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-300 mb-1">Email</label>
                        <input type="email" name="email"
                               class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"
                               required>
                    </div>

                    <!-- Тип подписки (селект) -->
                    <div>
                        <label class="block text-gray-300 mb-1">Выберите подписку</label>
                        <select name="subscription_type"
                                class="w-full px-3 py-2 rounded bg-gray-700 text-white border border-gray-600 focus:ring focus:ring-blue-500"
                                required>
                            <option value="">-- выбрать --</option>
                            <option value="Минимум">FREE</option>
                            <option value="Стандарт">Стандарт</option>
                            <option value="Enterprise">Enterprise</option>
                        </select>
                    </div>

                    <!-- Тип клиента (радио кнопки в виде блоков) -->
                    <div>
                        <label for="customer_type_individual" class="block text-gray-300 mb-1">Тип клиента</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label for="customer_type_individual" class="block cursor-pointer">
                                <input id="customer_type_individual" type="radio" name="customer_type"
                                       value="individual" class="hidden peer" checked>
                                <div
                                    class="p-4 bg-gray-700 border border-gray-600 rounded-lg text-center text-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-700 peer-checked:text-white">
                                    Физ. лицо
                                </div>
                            </label>
                            <label for="customer_type_company" class="block cursor-pointer">
                                <input id="customer_type_company" type="radio" name="customer_type" value="company"
                                       class="hidden peer">
                                <div
                                    class="p-4 bg-gray-700 border border-gray-600 rounded-lg text-center text-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-700 peer-checked:text-white">
                                    Юр. лицо
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Принятие политики -->
                    <div>
                        <label for="policy_accepted" class="flex items-center text-gray-300">
                            <input id="policy_accepted" type="checkbox" name="policy_accepted" class="mr-2" checked>
                            <div class="text-xs text-gray-400 mt-2">
                                Оформляя заказ, Вы подтверждаете, что ознакомлены и соглашаетесь с&#160;
                                <a href="/oferta" class="text-blue-400 underline">Публичной офертой</a>&#160;и&#160;
                                <a href="/policy" class="text-blue-400 underline">Политикой конфиденциальности</a>,&#160;
                                а также даёте согласие на обработку своих персональных данных.
                            </div>
                        </label>
                    </div>

                    <!-- Кнопка с исправленным ID -->
                    <button type="submit" id="submit-btn"
                            class="w-full py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">
                        Отправить заявку
                    </button>
                    <script
                        src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const form = document.getElementById('subscription-form');
                            const submitBtn = document.getElementById('submit-btn');
                            const formContainer = document.getElementById('subscription-form-container');
                            const loader = document.getElementById('loader');
                            const successMessage = document.getElementById('success-message');
                            let recaptchaReady = false;

                            function initRecaptcha() {
                                if (typeof grecaptcha === 'undefined') {
                                    console.error('reCAPTCHA script not loaded');
                                    return false;
                                }

                                grecaptcha.ready(() => {
                                    recaptchaReady = true;
                                    generateRecaptchaToken().catch(console.error);
                                });

                                return true;
                            }

                            async function generateRecaptchaToken() {
                                if (!recaptchaReady) {
                                    throw new Error('reCAPTCHA not initialized');
                                }

                                try {
                                    const token = await grecaptcha.execute(
                                        '{{ env('RECAPTCHA_SITE_KEY') }}',
                                        {action: 'submit'}
                                    );
                                    document.getElementById('g-recaptcha-response').value = token;
                                    return token;
                                } catch (error) {
                                    console.error('reCAPTCHA execution error:', error);
                                    throw new Error('Ошибка генерации токена безопасности');
                                }
                            }

                            // Инициализация reCAPTCHA
                            if (!initRecaptcha()) {
                                const script = document.createElement('script');
                                script.src = 'https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}';
                                script.onload = initRecaptcha;
                                script.onerror = () => console.error('Failed to load reCAPTCHA');
                                document.head.appendChild(script);
                            }

                            // Единственный обработчик submit
                            form.addEventListener('submit', async (e) => {
                                e.preventDefault();

                                const originalText = submitBtn.textContent;
                                submitBtn.disabled = true;
                                submitBtn.textContent = 'Отправка...';
                                formContainer.classList.add('hidden');
                                successMessage.classList.add('hidden');
                                loader.classList.remove('hidden');

                                try {
                                    await generateRecaptchaToken();

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

                                    const result = await response.json();
                                    loader.classList.add('hidden');

                                    if (result.success) {
                                        successMessage.classList.remove('hidden');
                                        form.reset();

                                        // Auto close modal in 2 seconds
                                        setTimeout(() => {
                                            const modal = document.getElementById('subscriptionModal');
                                            modal.classList.add('hidden');
                                        }, 2000);
                                    } else {
                                        alert('❌ ' + (result.message || 'Ошибка при отправке формы'));
                                        formContainer.classList.remove('hidden');
                                    }
                                } catch (error) {
                                    console.error('Form submission error:', error);
                                    loader.classList.add('hidden');
                                    formContainer.classList.remove('hidden');
                                    alert('❌ Ошибка при отправке формы');
                                } finally {
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = originalText;
                                }
                            });
                        }); // Закрытие DOMContentLoaded

                    </script>


                    <style>
                        .grecaptcha-badge {
                            display: none;
                        }
                    </style>
                </form>
            </div>
            <!-- Сообщение об успехе -->
            <div id="success-message" class="hidden mb-6 p-3 text-white text-center">
                ✅ Заявка успешно отправлена!
            </div>
            <div id="loader" role="status" class="hidden w-full flex justify-center  mb-6 p-3">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                     viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                        fill="currentColor"/>
                    <path
                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                        fill="currentFill"/>
                </svg>
                <span class="sr-only">Отправляем...</span>
            </div>
        </div>
    </div>
</div>

