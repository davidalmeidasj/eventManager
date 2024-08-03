FROM php:7.4-apache

# Instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    && docker-php-ext-install pdo pdo_mysql

# Configurar o PHP para exibir erros
RUN echo "display_errors=On" >> /usr/local/etc/php/php.ini
RUN echo "display_startup_errors=On" >> /usr/local/etc/php/php.ini
RUN echo "error_reporting=E_ALL" >> /usr/local/etc/php/php.ini

# Instalar o Dockerize para esperar a disponibilidade do banco de dados
RUN curl -sS -o /usr/local/bin/dockerize https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64 \
    && chmod +x /usr/local/bin/dockerize

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos necessários para o contêiner
COPY composer.json /var/www/html/composer.json
COPY phinx.php /var/www/html/phinx.php

# Instalar dependências do Composer
RUN composer install

# Copiar o restante dos arquivos do projeto
COPY src /var/www/html/src
COPY public /var/www/html/public
COPY db /var/www/html/db

# Habilitar o módulo rewrite do Apache
RUN a2enmod rewrite

# Configurar o Apache para servir arquivos do diretório public
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Configurar o entrypoint para esperar pelo banco de dados e iniciar o servidor Apache
COPY wait-for-it.sh /wait-for-it.sh
RUN chmod +x /wait-for-it.sh

CMD ["bash", "-c", "/wait-for-it.sh db:3306 -- composer install && composer dump-autoload && vendor/bin/phinx migrate && apache2-foreground"]
