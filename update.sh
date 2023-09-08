php artisan down
git pull
php ~/composer.phar install --no-dev --no-interaction
php artisan up

# Write Git version to file as shell_exec is disabled
git rev-parse HEAD > storage/interop/VERSION
