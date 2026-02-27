# Модуль: Интеграция с Telegram

## Назначение

Связь веб-приложения с Telegram-ботом: авторизация пользователей по Telegram ID (токены в БД), регистрация и логин через бота, получение списка тренировок и команд, опросы до/после тренировки, отметки посещаемости, фиксация достижений. Внутренние эндпоинты защищены секретом бота (`X-Bot-Secret`).

## Основные сущности

- **TelegramToken** — привязка пользователя к Telegram: хранение токена/идентификатора для безопасной аутентификации запросов от бота (миграция `harden_telegram_tokens_table`).  
- **User**: связь `telegramId()` с TelegramToken.

## Безопасность

- **TELEGRAM_BOT_SECRET** передаётся в заголовке `X-Bot-Secret` при вызове внутренних API; middleware `VerifyBotSecret` проверяет секрет.  
- Эндпоинты, связанные с токенами (`/api/telegram/*` по токенам), ограничены rate limiting: `throttle:30,1`.  
- Токены хранятся в БД, не в URL и не в логах (см. README и миграции).

## Ключевые API-маршруты

### Регистрация и авторизация

| Метод | Маршрут | Описание |
|-------|---------|----------|
| POST | `/api/register` | Регистрация из бота (TelegramRegisterController) |
| POST | `/api/login` | Вход из бота (TelegramLoginController) |
| POST | `/api/telegram/store-token` | Сохранение токена (внутренний) |
| GET | `/api/telegram/token/{telegram_id}` | Получение токена по telegram_id (внутренний) |

### Команды и игроки

| GET | `/api/telegram/get-my-teams/{user_id}` | Команды пользователя |
| GET | `/api/telegram/players-who-responded-today/{team_code}` | Игроки, ответившие сегодня на опросы |

### Тренировки и уведомления

| GET | `/api/trainings` | Список тренировок |
| GET | `/api/trainings-notify` | Уведомления о предстоящих тренировках |
| GET | `/api/after-trainings-notify` | Уведомления после тренировок (опрос) |
| POST | `/api/trainings-notify/{training_id}` | Отметка об отправке уведомления до |
| POST | `/api/trainings-after-notify/{training_id}` | Отметка об отправке уведомления после |
| GET | `/api/telegram/training/today-start/{team_code}` | Вопросы на сегодня по команде |
| GET | `/api/telegram/training/today-start-by-user/{user_id}` | Вопросы на сегодня по пользователю |
| GET | `/api/time-for-questions` | Время для вопросов |

### Опросы (Load Control)

| GET | `/api/telegram/question/check-already-answered/{user_id}` | Проверка, ответил ли пользователь |
| GET | `/api/telegram/question/check-load-allowed/{user_id}` | Разрешён ли опрос нагрузки |
| POST | `/api/questionnaire/answers-until-training-poll` | Ответы до тренировки |
| POST | `/api/questionnaire/answers-after-training-poll` | Ответы после тренировки |

### Достижения

| GET | `/api/achievements/types` | Типы достижений |
| POST | `/api/achievements` | Фиксация достижения |
| GET | `/api/achievements/history` | История достижений |

## Сервисы

- **TelegramService** — отправка сообщений, уведомлений и логика взаимодействия с Telegram Bot API.  
- **DockerBotService** — взаимодействие с docker-manager для запуска/остановки бота (см. [11-module-admin-docker](11-module-admin-docker.md)).

## Jobs

- **TelegramNotifyUserActiveChanged** — уведомление при смене статуса активности пользователя (например, при отключении игрока).

## Связь с другими модулями

- Пользователи: привязка по TelegramToken ([01-module-users](01-module-users.md)).  
- Тренировки и опросы: уведомления и время вопросов ([03-module-trainings](03-module-trainings.md), [07-module-load-control](07-module-load-control.md)).  
- Достижения: типы и фиксация из бота ([06-module-achievements](06-module-achievements.md)).  
- Управление ботом: Docker-контроллер для super-admin ([11-module-admin-docker](11-module-admin-docker.md)).
