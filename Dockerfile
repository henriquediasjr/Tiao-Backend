# Dockerfile para Laravel
FROM php:8.2-fpm

# Instalar dependências necessárias para Laravel e SQLite
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    unzip \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Criar diretório de trabalho
WORKDIR /var/www/html

# Copiar o código do Laravel
COPY . .

# Instalar dependências do Laravel
RUN composer install

# Configurar permissões e criar o arquivo SQLite
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

# Expor a porta padrão do PHP
EXPOSE 9000

# Comando inicial
CMD ["php-fpm"]
