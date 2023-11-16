# laravel-vue
 
1. сначала ставим Laravel
```composer create-project laravel/laravel <наименование проекта>```

2. потом через GitHub Desktop добавляем новый проект, размещаем его в гит

3. Потом накатываем облачную базу данных на сайте <https://www.freemysqlhosting.net/>
dasboard.app.activate@gmail.com
igj$D@bz@CVsG5s

4. Создаем базу данных в облаке и записываем их в .env
Server: sql12.freemysqlhosting.net
Name: sql12662580
Username: sql12662580
Password: 7q8pG2lDTz
Port number: 3306

5. Вносим изменения для работы с устаревшей базой данных MySql в облаке

config\database.php:
        ```'mysql' => [
            ...
            'engine' => 'InnoDB ROW_FORMAT=DYNAMIC',
            ...
        ],```

app\Providers\AppServiceProvider.php:
    ```public function boot(): void
    {
        Schema::defaultStringLength(191); 
    }```

6. Накатываем Breeze
```composer require laravel/breeze --dev```

7. Ставим структуру Breeze + Vue
```php artisan breeze:install
Which Breeze stack would you like to install - vue
Would you like any optional features - none
Which testing framework do you prefer - PHPUnit```