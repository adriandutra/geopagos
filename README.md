## About Test

#Conectar a la base de datos

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=geopagos
DB_USERNAME=root
DB_PASSWORD=

#Ejecutar las migraciones

php artisan migrate:refresh

#Luego levantar la aplicación

php artisan serve

