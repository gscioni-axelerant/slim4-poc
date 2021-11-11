FROM liketomove/php:8.0.11-fpm-alpine-dev

USER root

RUN xdebug-starter \
    && xoff

WORKDIR /var/www/app

USER utente

COPY --chown=utente:www-data ssh/* /home/utente/.ssh/

RUN chmod 600 /home/utente/.ssh/id_rsa \
    && touch /home/utente/.ssh/config && chmod 600 /home/utente/.ssh/config \
    && rm -rf ~/.composer/cache \
