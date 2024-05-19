# backend/Dockerfile

FROM php:8.2-fpm

# Definir diretório de trabalho
WORKDIR /var/www

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    netcat-openbsd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && pecl install redis \
    && docker-php-ext-enable redis

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copiar arquivos do projeto
COPY . /var/www

# Copiar configuração do PHP-FPM
COPY php-fpm.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Copiar script de entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expor porta 9000
EXPOSE 9000

# Definir entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Executar PHP-FPM
CMD ["php-fpm"]
