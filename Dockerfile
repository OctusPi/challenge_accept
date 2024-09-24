FROM php:8.3-apache

# Configura o diretório e as permissões
RUN mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html \
    && a2enmod rewrite

RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql

# Executar como www-data (usuário Apache)
USER www-data
