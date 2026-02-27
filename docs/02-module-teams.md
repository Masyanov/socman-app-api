# Модуль: Команды

## Назначение

Управление футбольными командами: создание, редактирование, удаление команд и привязка к ним игроков (спортсменов). Тренер видит только свои команды; фильтрация и выбор игроков по команде используются в тестах, тренировках, посещаемости и отчётах.

## Основные сущности

- **Team** — команда. Связана с владельцем (тренером) через `user_id`; идентификатор для API и привязки игроков — `team_code`.  
- **User** (игрок) — привязка к команде через поле `team_code` (внешний ключ на `teams.team_code`).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| GET | `/teams` | TeamController@index | Список команд тренера |
| POST | `/teams` | TeamController@store | Создание команды |
| GET | `/teams/{team}` | TeamController@show | Страница команды |
| PATCH | `/teams/{team}` | TeamController@update | Обновление команды |
| DELETE | `/teams/{team}` | TeamController@destroy | Удаление команды |
| POST | `/teams/{team}` | AjaxFilterController@ajaxFilter | AJAX-фильтр по команде |
| POST | `/teams/{team}/filter-chars` | AjaxFilterCharsController@ajaxCharsFilter | Фильтр по характеристикам |
| GET | `/teams/{team}/players` | TestController@getPlayersForTeam | Список игроков команды (для тестов) |

Маршруты доступны пользователям с ролью `coach` (middleware `auth`, `coach`).

## API (для бота)

- **GET** `/api/telegram/get-my-teams/{user_id}` — команды пользователя (для бота).  
- **GET** `/api/telegram/players-who-responded-today/{team_code}` — игроки команды, ответившие сегодня (на опросы).

## Модели и связи

- **Team**: владелец — User (тренер); игроки — User с `team_code = teams.team_code`.  
- Тренировки, тесты, достижения и опросы часто привязаны к команде или к игрокам команды.

## Связь с другими модулями

- Пользователи: тренер владеет командами; игроки привязаны к команде по `team_code` ([01-module-users](01-module-users.md)).  
- Тренировки: проводятся в контексте команд/игроков ([03-module-trainings](03-module-trainings.md)).  
- Тесты: выбор команды и игроков для тестов ([05-module-tests](05-module-tests.md)).  
- Посещаемость и Load Control: отчётность по командам ([04-module-attendance](04-module-attendance.md), [07-module-load-control](07-module-load-control.md)).
