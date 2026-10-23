FROM php:8.5-cli

WORKDIR /var/www

# =========================================================
# System dependencies
# =========================================================

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
    && rm -rf /var/lib/apt/lists/*

# =========================================================
# Composer
# =========================================================

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# =========================================================
# Laravel dependencies
# =========================================================

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# =========================================================
# Frontend dependencies
# =========================================================

COPY package.json package-lock.json ./

RUN npm ci

# =========================================================
# Application
# =========================================================

COPY . .

# =========================================================
# Environment
# =========================================================

COPY .env.docker .env

# =========================================================
# Laravel package discovery
# =========================================================

RUN composer dump-autoload --optimize

# =========================================================
# Generate Wayfinder
# =========================================================

RUN php artisan wayfinder:generate --with-form

# =========================================================
# Build frontend
# =========================================================

RUN npm run build

# =========================================================
# Laravel storage
# =========================================================

RUN mkdir -p \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

RUN chown -R www-data:www-data \
    storage \
    bootstrap/cache

# =========================================================
# Entry point
# =========================================================

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
