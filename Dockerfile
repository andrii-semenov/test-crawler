FROM php:7.4-fpm
COPY . /var/www/wwwcrawler
WORKDIR /var/www/wwwcrawler

RUN apt-get update && apt-get install -y \
        curl \
        wget

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

CMD ["php-fpm"]
