FROM php:8.2-apache

# Instalar extensiones necesarias para PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo_pgsql

# Copiar los archivos de tu repositorio al servidor web
COPY . /var/www/html/

# Exponer el puerto estándar
EXPOSE 80
