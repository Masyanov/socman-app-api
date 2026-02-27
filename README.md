# SportControl-app-api

Приложение для профессиональных тренеров по футболу

## Prod checklist (минимум по безопасности)

- **HTTPS**: выставить `APP_URL` на `https://...`, `APP_ENV=production`, `APP_DEBUG=false`. В проде приложение принудительно генерирует HTTPS ссылки.
- **Telegram Bot API**:
  - Задать `TELEGRAM_BOT_TOKEN`.
  - Задать `TELEGRAM_BOT_SECRET` и передавать его в заголовке `X-Bot-Secret` для внутренних эндпоинтов.
- **Rate limiting**:
  - Внутренние `/api/telegram/*` эндпоинты (токены) ограничены `throttle:30,1`.
- **Секреты**:
  - `.env` не должен попадать в репозиторий/бэкапы/публичные артефакты.

## Контракт docker-manager (для управления ботом из админки)

Админка (`/dashboard` для super-admin) вызывает:
- `POST /docker-bot/run|stop|restart|remove`
- `GET /docker-bot/status`

API проксирует это в `docker-manager` (см. `DOCKER_MANAGER_URL`) и возвращает фронту единый контракт:

```json
{
  "status": true,
  "state": "running",
  "output": "..."
}
```

- **status**: `true|false` — успешно ли выполнился запрос/операция
- **state**: `running|exited|unknown` — состояние бота (для UI)
- **output**: человекочитаемый вывод/ошибка

