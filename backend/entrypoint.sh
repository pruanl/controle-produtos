#!/bin/sh

# Copie .env.example para .env se .env não existir
if [ ! -f /var/www/.env ]; then
  cp /var/www/.env.example /var/www/.env
  php artisan key:generate
  # Substitua as variáveis de ambiente do banco de dados no .env
  sed -i 's/DB_HOST=127.0.0.1/DB_HOST=db/' /var/www/.env
  sed -i 's/DB_DATABASE=laravel/DB_DATABASE=controle_produtos/' /var/www/.env
  sed -i 's/DB_USERNAME=root/DB_USERNAME=root/' /var/www/.env
  sed -i 's/DB_PASSWORD=/DB_PASSWORD=root/' /var/www/.env
fi



# Aguarde o MySQL iniciar
until nc -z -v -w30 "$DB_HOST" 3306; do
  echo "Aguardando o MySQL iniciar..."
  sleep 5
done

# Execute as migrações e os seeders
php artisan migrate --force
php artisan db:seed --force

# Inicie o PHP-FPM
php-fpm
