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
    "php", "artisan", "serve",
    "--host", "0.0.0.0",
    "--port", "8000"
]

[nix]
channel = "stable-22_11"

[deployment]
run = ["sh", "-c", "php artisan serve"]
deploymentTarget = "cloudrun"
```

3. потом копируем .env.example.json в Raw Secrets Editor repl 


