FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite headers

# Install PostgreSQL PDO driver
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Set Apache DocumentRoot to /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Add CORS headers at the Apache level
RUN echo '<IfModule mod_headers.c>\n\
    Header always set Access-Control-Allow-Origin "*"\n\
    Header always set Access-Control-Allow-Methods "GET, POST, PUT, DELETE, OPTIONS"\n\
    Header always set Access-Control-Allow-Headers "Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With"\n\
</IfModule>\n\
\n\
RewriteEngine On\n\
RewriteCond %{REQUEST_METHOD} OPTIONS\n\
RewriteRule ^(.*)$ $1 [R=200,L]\n' > /etc/apache2/conf-available/cors.conf \
    && a2enconf cors

# Copy project files
COPY . /var/www/html/

# Apache listens on port 10000 for Render
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf

EXPOSE 10000

CMD ["apache2-foreground"]
