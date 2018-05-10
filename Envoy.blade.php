@servers(['web' => 'localhost'])

@task('local', ['on' => 'web'])
    ls -l
    php artisan api:cache
    php artisan config:cache
    php artisan route:cache
    php artisan route:clear
    php artisan config:clear
    php artisan api:croutes
@endtask