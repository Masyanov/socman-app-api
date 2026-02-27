# Модуль: Load Control и опросы

## Назначение

Контроль состояния игроков относительно собранных данных и их субъективной самооценки: настройка вопросов для опросов до и после тренировки, сохранение ответов из Telegram-бота, отображение данных и фильтрация в веб-интерфейсе. Доступ к модулю ограничен флагом **loadcontrol** у пользователя (включается super-admin).

## Основные сущности

- **Question** — вопрос опроса (привязка к пользователю-тренеру, тип: до тренировки / после тренировки).  
- **QuestionnaireAnswer** — ответ игрока на вопрос (связь с пользователем, тренировкой, датой, значение).  
- **SettingLoadcontrol** — настройки Load Control (время отправки вопросов и т.д.).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| GET | `/loadcontrol` | LoadControl@index | Страница Load Control |
| PATCH | `/loadcontrol` | LoadControl@update | Обновление настроек/данных Load Control |
| GET | `/loadcontrol/filter` | LoadControl@filter | Фильтрация данных |
| GET | `/questions` | LoadControlController@index | Список вопросов опроса |
| POST | `/questions` | LoadControlController@store | Создание вопроса |
| PATCH | `/questions` | LoadControlController@update | Обновление вопросов |
| DELETE | `/questions/{training}` | LoadControlController@destroy | Удаление привязки вопроса к тренировке |

Маршруты защищены middleware `auth`, `coach`, `loadcontrol` (кроме общих страниц, если есть).  
Маршруты создания/обновления/удаления вопросов частично доступны без `loadcontrol` для гибкой настройки (см. `routes/web.php`: `questions.store/update/destroy` вне группы loadcontrol).

## Вспомогательный маршрут

| GET | `/time` | TimeForQuestionsController@index | Время для вопросов (настройка/отладка) |

## API (для бота)

| Метод | Маршрут | Описание |
|-------|---------|----------|
| GET | `/api/telegram/question/check-already-answered/{user_id}` | Проверка, ответил ли пользователь уже на опрос |
| GET | `/api/telegram/question/check-load-allowed/{user_id}` | Проверка, разрешён ли опрос нагрузки для пользователя |
| POST | `/api/questionnaire/answers-until-training-poll` | Сохранение ответов опроса до тренировки |
| POST | `/api/questionnaire/answers-after-training-poll` | Сохранение ответов опроса после тренировки |

## Поведение

- Тренер настраивает вопросы и время отправки; опросы отправляются в Telegram до и после тренировок.  
- Игроки отвечают в боте; ответы сохраняются через API и отображаются в разделе Load Control.  
- В веб-интерфейсе доступны фильтрация и отчёты по состоянию и нагрузке.

## Модели и связи

- **User** (тренер): `questions()` — связь с Question.  
- **Question**: принадлежит пользователю-тренеру.  
- **QuestionnaireAnswer**: связь с пользователем (игрок), с тренировкой (при необходимости), дата, значение.

## Связь с другими модулями

- Тренировки: время опросов и привязка к тренировкам ([03-module-trainings](03-module-trainings.md)).  
- Пользователи: флаг loadcontrol выставляется super-admin ([01-module-users](01-module-users.md), [00-architecture](00-architecture.md)).  
- Telegram: отправка опросов и приём ответов ([08-module-telegram](08-module-telegram.md)).
