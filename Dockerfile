FROM php:8.3-apache

# Configura o diretório e as permissões
RUN mkdir -p /var/www/html \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html \
    && a2enmod rewrite

# Executar como www-data (usuário Apache)
USER www-data
