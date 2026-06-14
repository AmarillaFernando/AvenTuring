FROM dunglas/frankenphp:php8.3

RUN install-php-extensions pdo_mysql mysqli

WORKDIR /app

COPY . .

RUN ln -s /app /app/public

ENV SERVER_NAME=:8080
ENV APP_ENV=production