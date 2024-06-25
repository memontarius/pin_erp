
### Предварительные требования

* PHP ^8.1
* Make
* Composer
* Node.js & NPM

### Запуск с разворачиванием в Docker-контейнере

1. Установить зависимости

    ```sh
    make install
    ```
2. Подготовить конфигурационный файл
     ```sh
    make prepare-env
    ```
   
3. Настроить параметры в .env для доступа к базе и отправки почты (если требуется)

    ```dotenv
    DB_PASSWORD=your_password
    ...
    REDIS_PASSWORD=your_password
    ...
    MAIL_MAILER
    MAIL_HOST
    MAIL_PORT
    MAIL_USERNAME
    MAIL_PASSWORD
    MAIL_ENCRYPTION
    MAIL_FROM_ADDRESS
    ```
   
4. Настройка прав доступа
    ```sh
    make setup
    ```

5. Запуск контейнеров
    ```sh
    make up
    ```

6. Миграция и заполнение базы
    ```sh
    make c-mig
    make c-seed
    ```
