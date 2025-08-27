# Usar imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instalar dependências e pdo_mysql
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    libonig-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql

# Copiar os arquivos do projeto para o diretório do Apache
COPY . /var/www/html/

# Dar permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Ajustar ServerName para evitar warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expor a porta 80
EXPOSE 80

# Manter o Apache rodando em foreground
CMD ["apache2-foreground"]