php artisan cache:clear
php artisan route:cache
php artisan api:cache
php artisan config:cache
composer dump-autoload

echo "YES" | php artisan migrate --database='seguridad' --path='database/migrationsSeguridad'
echo "YES" | php artisan migrate --database='cadeco'

echo "YES" | php artisan db:seed --class='TiposRubrosSeeder'
echo "YES" | php artisan db:seed --class='TiposSolicitudSeeder'
echo "YES" | php artisan db:seed --class='RubrosSeeder'
echo "YES" | php artisan db:seed --class='RolesPermissionsSeeder'

