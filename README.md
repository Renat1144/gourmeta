# Gourmeta

[Открыть публичную копию сайта Gourmeta](https://renat1144.github.io/gourmeta/)

Исходный код сайта Gourmeta на WordPress и настройки для разработки в Docker. Ресурсы собственной темы входят в репозиторий. Рабочая база, медиатека, материалы бренда и локальные реквизиты передаются отдельно.

## Запуск после клонирования

Запусти Docker с Linux-контейнерами. В корне репозитория выполни команды.

```sh
docker compose run --rm --no-deps prepare
docker compose up -d --wait
```

Сайт доступен на <http://127.0.0.1:8187/>, админка на <http://127.0.0.1:8187/wp-admin/>. Для пустой базы откроется установщик WordPress.

Чтобы получить рабочую копию Gourmeta с содержимым, перед первым запуском скопируй `local/database/gourmeta.sql` и `gourmeta.ru/docs/wp-content/uploads/` из приватной папки переноса. В ней также хранится ролик старого шаблона `gourmeta.ru/docs/wp-content/themes/gourmeta/js/jwplayer/video.mp4`. Данные входа в рабочую локальную админку передаются отдельно. Инструкции по обновлению дампа и текущее состояние проекта описаны в [PROJECT_HANDOFF.md](PROJECT_HANDOFF.md).
