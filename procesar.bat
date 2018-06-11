git pull origin feature/cargaDePrecios
php artisan db:seed
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan api:cache
gulp --production



