# Модуль: Достижения

## Назначение

Система фиксации достижений игроков: тренер настраивает, какие типы достижений доступны (голы, передачи, сейвы, жонглирование и т.д.); игрок фиксирует достижения в Telegram-боте. В веб-интерфейсе — выбор типов достижений для команды/игроков, настройка списка типов, просмотр графиков и статистики.

## Основные сущности

- **AchievementType** — тип достижения (название, код, привязка к тренерам через pivot `achievement_type_user`).  
- **PlayerAchievement** — факт достижения игрока (связь User + AchievementType, дата, количество/значение при необходимости).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| GET | `/achievements` | AchievementSelectionController@index | Выбор достижений (по команде/игрокам) |
| POST | `/achievements` | AchievementSelectionController@update | Сохранение выбора достижений |
| GET | `/achievements/settings` | AchievementSettingsController@edit | Настройка типов достижений |
| POST | `/achievements/settings` | AchievementSettingsController@update | Сохранение типов достижений |

Маршруты доступны пользователям с ролью `coach` (middleware `auth`, `coach`).

## API (для бота)

| Метод | Маршрут | Описание |
|-------|---------|----------|
| GET | `/api/achievements/types` | Список типов достижений для пользователя/команды |
| POST | `/api/achievements` | Сохранение достижения (фиксация из бота) |
| GET | `/api/achievements/history` | История достижений (для отображения в боте/отчётах) |

## Поведение

- Тренер в настройках выбирает, какие типы достижений доступны его командам/игрокам.  
- Игрок в Telegram-боте выбирает тип и фиксирует достижение; данные сохраняются через API.  
- В веб-интерфейсе отображаются графики и статистика по достижениям.

## Модели и связи

- **User** (тренер): `achievementTypes()` — многие-ко-многим с AchievementType (pivot `achievement_type_user`).  
- **User** (игрок): `playerAchievements()` — связь с PlayerAchievement.  
- **PlayerAchievement**: связь с User и AchievementType.

## Связь с другими модулями

- Пользователи и команды: типы достижений привязаны к тренеру; фиксация — к игрокам и их командам ([01-module-users](01-module-users.md), [02-module-teams](02-module-teams.md)).  
- Telegram: фиксация достижений из бота и получение типов ([08-module-telegram](08-module-telegram.md)).
