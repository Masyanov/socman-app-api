# Модуль: Подписки

## Назначение

Управление подписками пользователей (тренеров) на тарифы: просмотр и изменение подписок super-admin’ом, приём заказов на подписку (оформление заказа через веб). Связь с продуктами (тарифами) и учётом доступа к функциям (например, Load Control может зависеть от тарифа).

## Основные сущности

- **Subscription** — подписка пользователя на продукт/тариф (связь User, даты начала/окончания, статус).  
- **SubscriptionOrder** — заказ на подписку (оформление через форму/страницу).  
- **Product** — продукт/тариф (название, описание, цена и т.д.).

## Ключевые маршруты (web)

| Метод | Маршрут | Контроллер | Описание |
|-------|---------|------------|----------|
| POST | `/subscription-order` | SubscriptionOrderController@store | Оформление заказа на подписку (может быть доступно без super-admin) |
| GET | `/subscriptions` | SubscriptionController@index | Список подписок (super-admin) |
| PATCH | `/subscriptions/{id}` | SubscriptionController@update | Обновление подписки (super-admin) |
| DELETE | `/subscriptions/{id}` | SubscriptionController@destroy | Удаление подписки (super-admin) |

Маршруты управления подписками (index/update/destroy) защищены middleware `auth`, `super-admin`.

## Поведение

- Пользователь (тренер) может оформить заказ на подписку через форму (subscription-order).  
- Super-admin видит список подписок, редактирует и удаляет их.  
- Подписки могут влиять на доступ к модулям (например, Load Control) в связке с флагами пользователя.

## Модели и связи

- **User**: `subscriptions()` — связь с Subscription.  
- **Subscription**: связь с User и с Product (при наличии модели продукта).  
- **SubscriptionOrder**: данные заказа, при необходимости связь с User.

## Связь с другими модулями

- Пользователи: у тренера могут быть одна или несколько подписок ([01-module-users](01-module-users.md)).  
- Роли и доступ: super-admin управляет подписками ([00-architecture](00-architecture.md)).
