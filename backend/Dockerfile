FROM php:8.3-fpm-alpine AS builder

RUN apk add --no-cache \
        autoconf \
        gcc \
        g++ \
        make \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        postgresql-dev

RUN docker-php-source extract \
    && pecl install redis \
    && docker-php-source delete

RUN docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        zip \
        intl \
        opcache \
        bcmath \
    && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist

COPY . ./

RUN mkdir -p var/cache var/log \
    && chmod -R 777 var

FROM php:8.3-fpm-alpine AS dev

RUN apk add --no-cache \
        postgresql-client \
        curl \
        dumb-init \
        libzip \
        icu \
        oniguruma

COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer
COPY --from=builder /app /app
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

RUN docker-php-ext-enable pdo_pgsql redis bcmath intl zip

RUN addgroup -g 1000 -S appuser \
    && adduser -u 1000 -S appuser -G appuser \
    && chown -R appuser:appuser /app

USER appuser

WORKDIR /app

EXPOSE 8000

CMD ["dumb-init", "php", "-S", "0.0.0.0:8000", "-t", "public", "-d", "variables_order=EGPCS"]

FROM php:8.3-fpm-alpine AS runtime

RUN apk add --no-cache \
        postgresql-client \
        curl \
        dumb-init \
        libzip \
        icu \
        oniguruma

COPY --from=builder /usr/local/bin/composer /usr/local/bin/composer
COPY --from=builder /app /app
COPY --from=builder /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=builder /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

RUN docker-php-ext-enable pdo_pgsql redis bcmath intl zip

RUN addgroup -g 1000 -S appuser \
    && adduser -u 1000 -S appuser -G appuser \
    && chown -R appuser:appuser /app

USER appuser

WORKDIR /app

HEALTHCHECK --interval=30s --timeout=10s --start-period=30s --retries=3 \
    CMD curl -f http://localhost:8000/health || exit 1

EXPOSE 8000

CMD ["dumb-init", "php", "-S", "0.0.0.0:8000", "-t", "public", "-d", "variables_order=EGPCS"]
