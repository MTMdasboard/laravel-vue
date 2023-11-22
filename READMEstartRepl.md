# laravel-vue
 
1. сначала обновляем replit.nix и перезагружаем repl (надо включить show hiden files)
```
{ pkgs }: {
	deps = [
		pkgs.php82
    pkgs.php82Packages.composer
    pkgs.nodejs-19_x
	];
}
```

2. потом обновляем .replit
```
run = [
    "php", "artisan", "octane:start",
    "--host", "0.0.0.0",
    "--port", "8000"
]

[nix]
channel = "stable-22_11"

[deployment]
run = ["sh", "-c", "php artisan octane:start"]
deploymentTarget = "cloudrun"
```

3. потом копируем .env.example.json в Raw Secrets Editor repl 
там обновлены поля:
```
"APP_ENV": "production",
"APP_DEBUG": "false",
"APP_URL": "НАДО ПРОПИСАТЬ URL",
```

4. Потом запускаем команды в shell
composer update
composer require laravel/octane
composer require spiral/roadrunner-cli
./vendor/bin/rr get-binary
composer install --optimize-autoloader --no-dev
npm install
npm run build
composer dump-autoload
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache