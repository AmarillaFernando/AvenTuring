FROM dunglas/frankenphp:php8.3

RUN install-php-extensions pdo_mysql mysqli

WORKDIR /app

COPY . .

ENV FRANKENPHP_DOCUMENT_ROOT=/app
ENV SERVER_NAME=:8080
ENV APP_ENV=production