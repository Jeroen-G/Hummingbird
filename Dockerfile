FROM php:8.0-cli

COPY . /www

WORKDIR /www

ENTRYPOINT ["php", "./bin/console"]

CMD [ "list" ]
