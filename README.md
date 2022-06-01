1. Чтобы развернуть проект:

- В файле `/etc/hosts` прописать `127.0.0.1 wow.loc`.
- В корне проекта создать файл `.env` с помощью команды `cp .env.example .env`.
- В папке `public` создать папку `build` и в ней файл `manifest.json`, с таким содержимым `{}`.
- Выполнить команду `make init-build`.
- Когда процесс упадет с ошибкой `failed to authenticate user [elastic]`, выполнить `пункт 5`.
- Далее поочередно:
  `make migrate`
  `make populate`
  `make watch`
- Также для полноценной работы выполнить `пункты 3 и 4`.

2. Зайти в контейнер (`make bash`) и выполнить команду (для индексации данных в ElasticSearch):
   `php bin/console fos:elastica:populate`
   или в корне проекта
   `make populate`

3. Чтобы отправлялись sms, emails, а также отрабатывали background процессы - запустить воркеры для
   очереди:
   `make messenger`

4. Поднять веб-сокет сервер - зайти в контейнер (`make bash`) и выполнить:
   `php bin/console chat:start`

5. Чтобы задать пароль для ELK - перейти в `laradock` и выполнить:
   `sudo docker-compose exec elasticsearch `
   `bash bin/elasticsearch-setup-passwords interactive`
   `eGWVQ2QrMe6UspvAczaGcadUe8JFHSKyb8BuPyCp72LeYAjMZehxGyqc7KhZ6n4ex`

6. Поставить cron задачу на выполнение каждый день (удаление черновиков заказов):
   `php bin/console app:order-remove-draft`
