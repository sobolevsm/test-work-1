# Тестовое задание
## Установка проекта

1. Поднимите проект с использованием Docker Compose: `docker-compose up -d`
2. Создайте файл .env из примера .env.example и настройте необходимые переменные окружения.
3. Если на машине установлен composer, то запустите команду composer install, если нет, то можно зайти в контейнер через
`docker-compose exec app bash` и запустить команду там.

## Доступ к проекту

После успешной установки и запуска проекта, он будет доступен в вашем веб-браузере по адресу: `http://localhost:8081`

Вы также можете настроить порт, используя переменную окружения NGINX_PORT в файле .env.

## Нереализованный функционал
1. Парсинг данных с сайта alza.cz: В настоящий момент функция парсинга данных с сайта alza.cz не реализована в полной мере из-за проблем с блокировкой запросов Cloudflare и получением ошибок 403 (Forbidden) при запросах к сайту.
2. Тестирование: Из-за сложностей с выполнением реальных запросов для парсинга, проведение тестирования не было осуществлено.