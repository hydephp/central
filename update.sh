if [ -e "storage/interop/UPDATE.lock" ]; then
    echo "Fatal: An update is already in progress";
    exit 1;
fi
touch storage/interop/UPDATE.lock;

php artisan down

# Add and stash untracked files in case public directory has changed
git add *
git stash
git pull

php ~/composer.phar install --no-dev --no-interaction
php artisan up

# Write Git version to file as shell_exec is disabled
git rev-parse HEAD > storage/interop/VERSION

# A hook to run system specific post-deployment code
if [ -e ".post-update.sh" ]; then
    bash .post-update.sh >> storage/logs/update.log;
fi

rm storage/interop/UPDATE.lock;
exit 0;
