# Модуль: Пользователи и спортсмены

## Назначение

Учёт пользователей системы (тренеры, админы, super-admin) и спортсменов (игроков): профили, контакты, привязка к командам, метаданные и настройки. Отдельно учитываются привязка к Telegram и флаги доступа к модулям (AI, Load Control).

## Роли

- **Тренер (coach)** — создаёт и редактирует игроков (спортсменов), привязывает их к своим командам.  
- **Админ (admin)** — управляет тренерами (связь admin ↔ coach через `admin_coach`), может входить под тренером.  
- **Super-admin** — включает/выключает у пользователя доступ к AI и Load Control (`update-ai`, `update-load_control`), может входить под любым пользователем.

## Основные сущности

- **User** — пользователь системы (тренер, админ, super-admin) или спортсмен (игрок). Роль задаётся полем `role`; привязка к команде — через `team_code` (у игрока) или через связь `teams()` у тренера (тренер владеет командами).  
- **UserMeta** — дополнительные данные профиля (рост, вес, позиция, фото и т.д.).  
- **SettingUser** — настройки пользователя.  
- **TelegramToken** — привязка аккаунта к Telegram (см. [Модуль Telegram](08-module-telegram.md)).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| GET | `/users` | UserController@index | Список пользователей (игроков) |
| POST | `/users` | UserController@store | Создание пользователя |
| GET | `/users/{user}` | UserController@show | Карточка пользователя |
| PATCH | `/users/{id}` | UserController@update | Обновление пользователя |
| DELETE | `/users/{user}` | UserController@destroy | Удаление пользователя |
| PATCH | `/users/{id}/update-active-player` | UserController@updateActive | Обновление флага «активный игрок» |
| GET | `/admin/players_info/{id}` | UserController@getPlayerInfo | Информация об игроке (для админки/экспорта) |
| PATCH | `/users/{id}/update-ai` | UserController@updateAI | Вкл/выкл доступа к AI (super-admin) |
| PATCH | `/users/{id}/update-load_control` | UserController@updateLoadControl | Вкл/выкл Load Control (super-admin) |
| DELETE | `/users/{id}/delete-coach` | UserController@destroyCoach | Удаление тренера (admin) |

Все маршруты управления пользователями/игроками защищены middleware `auth` и при необходимости `coach` или `admin`/`super-admin`.

## Модели и связи

- **User**: `teams()`, `team()` (для игрока по `team_code`), `meta()`, `settings()`, `presence()`, `telegramId()`, `achievementTypes()`, `playerAchievements()`, `subscriptions()`, `coaches()`, `admins()`.  
- **UserMeta**: связь с User.  
- **TelegramToken**: связь с User (один токен на пользователя по `telegram_id`).

## Связь с другими модулями

- Команды: игрок привязан к команде по `team_code` ([02-module-teams](02-module-teams.md)).  
- Тренировки и посещаемость: учёт присутствия через `PresenceTraining` ([03-module-trainings](03-module-trainings.md), [04-module-attendance](04-module-attendance.md)).  
- Достижения: тренер настраивает типы достижений, игрок фиксирует в боте ([06-module-achievements](06-module-achievements.md)).  
- Подписки: у пользователя (тренера) — подписки на тарифы ([09-module-subscriptions](09-module-subscriptions.md)).
