docker exec swd_app composer install
docker exec swd_app php artisan migrate --force
docker exec swd_app php artisan apiato:swagger
docker exec swd_app composer du
docker restart swd_app
docker restart swd_queue
docker start swd_nginx
