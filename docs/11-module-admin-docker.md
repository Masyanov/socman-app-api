# Модуль: Админка и управление Docker-ботом

## Назначение

Функции super-admin: управление подписками (см. [09-module-subscriptions](09-module-subscriptions.md)), включение/выключение доступа к AI и Load Control у пользователей, вход под любым пользователем, а также управление жизненным циклом Telegram-бота через внешний сервис **docker-manager** (run, stop, restart, remove).

## Управление пользователями (super-admin)

| Метод | Маршрут | Описание |
|-------|---------|----------|
| PATCH | `/users/{id}/update-ai` | Включить/выключить доступ к AI |
| PATCH | `/users/{id}/update-load_control` | Включить/выключить доступ к Load Control |
| GET | `/loginAsUser/{id}` | Вход под пользователем (сохраняется session `super-admin`) |
| GET | `/go-to-super-admin` | Выход из «входа под пользователем», возврат к super-admin |

## Управление Docker-ботом

Дашборд super-admin вызывает API приложения; приложение проксирует запросы в **docker-manager** (URL задаётся в `DOCKER_MANAGER_URL`).

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| POST | `/docker-bot/run` | DockerBotController | Запуск бота |
| POST | `/docker-bot/stop` | DockerBotController | Остановка бота |
| POST | `/docker-bot/restart` | DockerBotController | Перезапуск бота |
| POST | `/docker-bot/remove` | DockerBotController | Удаление контейнера/сервиса бота |
| GET | `/docker-bot/status` | DockerBotController | Получение состояния бота |

Все маршруты защищены middleware `auth`, `super-admin`.

## Контракт ответа docker-manager

Приложение возвращает фронту единый формат (см. README в корне проекта):

```json
{
  "status": true,
  "state": "running",
  "output": "..."
}
```

- **status** — успех выполнения запроса (true/false).  
- **state** — состояние бота: `running`, `exited`, `unknown` (для отображения в UI).  
- **output** — человекочитаемый вывод или сообщение об ошибке.

## Реализация

- **DockerBotController** — приём запросов от веб-интерфейса и вызов docker-manager.  
- **DockerBotService** — HTTP-клиент и логика обмена с docker-manager.

## Impersonate (админ → тренер)

Админ (роль `admin`) может войти под тренером, привязанным к нему через `admin_coach`:

| GET | `/adminLoginAsUser/{id}` | Вход под тренером (session `impersonate` = admin id) |
| GET | `/impersonate/leave` | Выход из impersonate, возврат к аккаунту админа |

Маршруты защищены middleware `auth`, `admin`.

## Связь с другими модулями

- Пользователи: флаги AI и Load Control ([01-module-users](01-module-users.md)).  
- Подписки: управление в админке ([09-module-subscriptions](09-module-subscriptions.md)).  
- Telegram: бот управляется через docker-manager ([08-module-telegram](08-module-telegram.md)).
