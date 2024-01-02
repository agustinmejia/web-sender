<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

# WebSender
Panel de administración para el envío de mensajes masivos utilizando un servidor de whatsapp web.

## Instalación
```
sudo apt install php8.0-mbstring php8.0-intl php8.0-dom php8.0-gd php8.0-xml php8.0-zip php8.0-mysql
composer install
cp .env.example .env
php artisan template:install
chmod -R 777 storage bootstrap/cache
```
## Iniciar servicios
<!-- Iniciar proceso que obtiene los primeros 10 mensajes pendientes y los envía con un periodo de espera de 5 segundo (Este proceso se ejecuta automáticamente cada minuto) 
```
pm2 start schedule.yml
``` -->
Iniciar proceso que ejecuta el envío de mensajes
```
pm2 start worker.yml --name "web-sender-work"
```

## Colaboradores

<a href="https://github.com/agustinmejia/laravel_template/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=agustinmejia/laravel_template" />
</a>