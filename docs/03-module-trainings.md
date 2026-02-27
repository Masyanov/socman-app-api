# Модуль: Тренировки

## Назначение

Планирование и учёт тренировок и матчей: календарь, создание/редактирование/удаление тренировок, прикрепление планов с упражнениями и целями. Интеграция с уведомлениями в Telegram и с опросами до/после тренировки (время отправки вопросов, отметки об отправке).

## Основные сущности

- **Training** — тренировка/матч: дата, время, привязка к команде/тренеру, адрес, тип (тренировка/матч) и т.д.  
- **ClassTraining** — класс/тип занятия (связь с тренировкой).  
- **AddressesTraining** — адреса проведения тренировок (справочник).  
- **TrainingNotification** — уведомления о тренировке (отправка в Telegram, отметки «до» и «после»).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| GET | `/trainings` | TrainingController@index | Список тренировок |
| POST | `/trainings` | TrainingController@store | Создание тренировки |
| GET | `/trainings/{training}` | TrainingController@show | Просмотр тренировки |
| PATCH | `/trainings/{training}` | TrainingController@update | Обновление тренировки |
| DELETE | `/trainings/{training}` | TrainingController@destroy | Удаление тренировки |
| POST | `/trainings/settings` | TrainingController@settings | Настройки тренировок |
| POST | `/trainings/addresses` | TrainingController@addressesTrainings | Добавление адреса |
| DELETE | `/trainings/addresses/{address}` | TrainingController@deleteAddressesTrainings | Удаление адреса |
| DELETE | `/trainings/class/{class}` | TrainingController@deleteClassTraining | Удаление класса тренировки |
| GET | `/calendar` | TrainingController@calendar | Календарь тренировок |

Маршруты доступны пользователям с ролью `coach` (middleware `auth`, `coach`).

## API (для бота)

| Метод | Маршрут | Описание |
|-------|---------|----------|
| GET | `/api/trainings` | Список тренировок (для бота) |
| GET | `/api/trainings-notify` | Уведомления о предстоящих тренировках |
| GET | `/api/after-trainings-notify` | Уведомления после тренировок (опрос) |
| POST | `/api/trainings-notify/{training_id}` | Отметка об отправке уведомления до тренировки |
| POST | `/api/trainings-after-notify/{training_id}` | Отметка об отправке уведомления после тренировки |
| GET | `/api/telegram/training/today-start/{team_code}` | Готовность вопросов на сегодня по команде |
| GET | `/api/telegram/training/today-start-by-user/{user_id}` | Готовность вопросов по пользователю |
| GET | `/api/time-for-questions` | Время для вопросов (настройка опросов) |

## Связь с другими модулями

- Команды и игроки: тренировки привязаны к команде/тренеру; посещаемость — по игрокам ([02-module-teams](02-module-teams.md), [01-module-users](01-module-users.md)).  
- Посещаемость: отметки присутствия на тренировках ([04-module-attendance](04-module-attendance.md)).  
- Load Control и опросы: время опросов, вопросы до/после тренировки ([07-module-load-control](07-module-load-control.md)).  
- Telegram: уведомления и опросы ([08-module-telegram](08-module-telegram.md)).
