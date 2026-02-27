# Документация SportControl

**SportControl** — веб-приложение и Telegram-бот для профессиональных тренеров по футболу: учёт спортсменов, планирование тренировок, сбор данных о состоянии игроков и анализ нагрузки.

## Навигация по документации

| Документ | Описание |
|----------|----------|
| [Обзор приложения](00-overview.md) | Назначение, целевая аудитория, основные возможности |
| [Архитектура и роли](00-architecture.md) | Стек, роли пользователей, безопасность |

### Модули приложения

| № | Модуль | Файл | Краткое описание |
|---|--------|------|------------------|
| 1 | Пользователи и спортсмены | [01-module-users.md](01-module-users.md) | Профили игроков, тренеры, админы |
| 2 | Команды | [02-module-teams.md](02-module-teams.md) | Управление командами и привязка игроков |
| 3 | Тренировки | [03-module-trainings.md](03-module-trainings.md) | Календарь, планы тренировок, уведомления |
| 4 | Посещаемость | [04-module-attendance.md](04-module-attendance.md) | Учёт посещений, календарь явки |
| 5 | Тестирование игроков | [05-module-tests.md](05-module-tests.md) | Тесты, результаты, импорт, радар-графики |
| 6 | Достижения | [06-module-achievements.md](06-module-achievements.md) | Типы достижений, фиксация в боте, статистика |
| 7 | Load Control и опросы | [07-module-load-control.md](07-module-load-control.md) | Опросы до/после тренировки, контроль состояния |
| 8 | Интеграция с Telegram | [08-module-telegram.md](08-module-telegram.md) | Бот, авторизация, опросы, уведомления |
| 9 | Подписки | [09-module-subscriptions.md](09-module-subscriptions.md) | Тарифы, заказы, управление подписками |
| 10 | AI-анализ | [10-module-ai-analyze.md](10-module-ai-analyze.md) | Анализ состояния игроков и рекомендации |
| 11 | Админка и Docker-бот | [11-module-admin-docker.md](11-module-admin-docker.md) | Super-admin, управление ботом через docker-manager |

## Исходный код

- Веб-API и фронтенд: `socman-app-api/` (Laravel, Blade, Vue/JS).
- Конфигурация продакшена и контракт docker-manager: см. `socman-app-api/README.md` и `socman-app-api/PROJECT.md`.
