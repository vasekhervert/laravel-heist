# HeistChannel

## Instalace

1. Nainstalujte závislosti

    ```
    composer install
    ```

2. Zkopírujte `.env.example` do `.env` a nastavte databázi na SQLite

    ```
    cp .env.example .env
    ```

    V `.env` doplňte FB a Google api keys, secrets a redirect callbacks:

    ```
    FACEBOOK_CLIENT_ID=XXXXXXXXXXXXXXXX
    FACEBOOK_CLIENT_SECRET=XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX

    GOOGLE_CLIENT_ID=XXXXXXXXXXXX-xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.apps.googleusercontent.com
    GOOGLE_CLIENT_SECRET=XXXXXX-XXXX-xxxxxxxxxxxxxxxxxxxxxxx
    ```

3. Vygenerujte aplikační klíč

    ```
    php artisan key:generate
    ```

4. Spusťte vývojový server

    ```
    php artisan serve
    ```

5. Navštivte `http://localhost:8000` ve vašem prohlížeči

## Přihlašovací údaje

-   Email: locksmith@heistmail.com, Heslo: 12345678
-   Email: mastermind@heistmail.com, Heslo: 12345678
-   Email: hacker@heistmail.com, Heslo: 12345678
-   Email: muscle@heistmail.com, Heslo: 12345678
-   FB/GOOGLE Login
-   Registrace
