docker compose --env-file ./www/.env stop

docker compose --env-file ./www/.env up -d

docker compose --env-file ./www/.env build

docker exec --env-file ./www/.env -it --user root sshd_laravel_dhcp bash

php artisan passport:keys --force

php artisan passport:install

php artisan passport:client --password

