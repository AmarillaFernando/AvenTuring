FROM dunglas/frankenphp:php8.3

RUN install-php-extensions \
    pdo_mysql \
    mysqli

WORKDIR /app

COPY . /app

EXPOSE 8080

CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]