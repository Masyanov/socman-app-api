# Архитектура и роли

## Технологический стек

- **Backend**: Laravel (PHP)  
- **Frontend**: Blade-шаблоны, JavaScript (Vue/кастомный JS при необходимости)  
- **API**: REST API для Telegram-бота и внешних вызовов  
- **Аутентификация**: Laravel auth (web), Sanctum (API), отдельная модель токенов для Telegram  

## Роли пользователей

| Роль | Описание | Доступ |
|------|----------|--------|
| **Тренер (coach)** | Основной пользователь: управляет командами, игроками, тренировками, тестами, достижениями, опросами. Видит дашборд тренера, календарь, Load Control (при включённом модуле). | Веб: команды, игроки, тренировки, тесты, посещаемость, достижения, опросы, Load Control, календарь. |
| **Админ (admin)** | Управляет тренерами (привязка coach к admin). Может входить «под тренером» (impersonate). | Удаление тренера, вход под тренером (`/adminLoginAsUser/{id}`), выход из impersonate (`/impersonate/leave`). |
| **Super-admin** | Полный доступ: подписки, флаги пользователей (AI, Load Control), управление Docker-ботом (run/stop/restart/remove), вход под любым пользователем. | `/subscriptions`, `/docker-bot/*`, `/users/{id}/update-ai`, `/users/{id}/update-load_control`, `/loginAsUser/{id}`, `/go-to-super-admin`. |

Роль задаётся полем `role` у пользователя; проверка — через middleware `coach`, `admin`, `super-admin`, `loadcontrol`.

## Модуль Load Control

Доступ к разделу Load Control и опросам ограничен не только ролью «тренер», но и флагом **loadcontrol** у пользователя (включается super-admin). Маршруты Load Control и вопросов защищены middleware `auth`, `coach`, `loadcontrol`.

## Безопасность (кратко)

- **HTTPS**: в проде `APP_URL` с `https://`, `APP_ENV=production`, `APP_DEBUG=false`.  
- **Telegram Bot API**: `TELEGRAM_BOT_TOKEN`, `TELEGRAM_BOT_SECRET` для внутренних эндпоинтов (заголовок `X-Bot-Secret`).  
- **Rate limiting**: эндпоинты `/api/telegram/*` (токены) — `throttle:30,1`.  
- Секреты в `.env` не должны попадать в репозиторий и публичные артефакты.

## Структура кода (высокоуровнево)

- **Модели**: `app/Models/` — User, Team, Training, Test, PlayerTest, AchievementType, PlayerAchievement, Question, QuestionnaireAnswer, Subscription, TelegramToken и др.  
- **Контроллеры**: `app/Http/Controllers/` — веб-логика; `app/Http/Controllers/Api/` — API для бота и внешних сервисов.  
- **Сервисы**: `app/Services/` — TelegramService, UserService, DockerBotService и т.д.  
- **Маршруты**: `routes/web.php` (веб), `routes/api.php` (API).  
- **Middleware**: `auth`, `coach`, `admin`, `super-admin`, `loadcontrol`, `VerifyBotSecret` (для эндпоинтов бота).

Детали по каждому модулю см. в соответствующих файлах `01-module-*.md` … `11-module-*.md`.
