########################################################################################################################
# XHPROF IMAGE
########################################################################################################################
FROM php:8.0-cli as xhprof

RUN apt-get update && apt-get install -y git && apt-get clean
RUN git clone https://github.com/longxinH/xhprof && \
   cd xhprof/extension && \
   phpize && \
   ./configure && \
   make && \
   cp ./modules/xhprof.so /xhprof.so

########################################################################################################################
# Base Image
########################################################################################################################
FROM anatoliygerasimov/php:8.0-base as php-base-image

COPY ./docker/php/conf.d/xdebug.ini /etc/php/8.0/fpm/conf.d/30-xdebug.ini
COPY ./docker/php/conf.d/laravel.ini /etc/php/8.0/fpm/conf.d/30-laravel.ini

ARG APP_USER
ARG USER_ID

ENV APP_USER=${APP_USER}
ENV USER_ID=${USER_ID}

###########################################################################
# XHprof:
###########################################################################
COPY --from=xhprof /xhprof /xhprof
COPY --from=xhprof /xhprof.so /tmp/xhprof.so

#####################################
# Dependencies
#####################################
RUN apt-get update && apt-get install -yq cron git ffmpeg supervisor mysql-client xvfb libfontconfig wkhtmltopdf \
    # Need to MediaLibrary
    jpegoptim optipng pngquant gifsicle \
    # Need to Imagick
    libmagickwand-dev --no-install-recommends && \
    # XHprof: \
    mkdir /var/www/profiles && \
    mv /tmp/xhprof.so /usr/lib/php/20200930 && \
    echo "extension=xhprof.so" > /etc/php/8.0/fpm/conf.d/30-xhprof.ini && \
    echo "xhprof.output_dir=/var/www/profiles" >> /etc/php/8.0/fpm/conf.d/30-xhprof.ini && \
    echo "extension=xhprof.so" > /etc/php/8.0/cli/conf.d/30-xhprof.ini && \
    echo "xhprof.output_dir=/var/www/profiles" >> /etc/php/8.0/cli/conf.d/30-xhprof.ini && \
    # Node.js:
    apt-get update && apt-get install -yq ca-certificates && \
    curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get -y install nodejs && \
    npm -g install npm@latest --no-install-recommends && \
    npm config set cache /tmp --global && \
    # Clean
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    # Permission for xhprof folder
    chown $APP_USER:$APP_USER /var/www/profiles
###########################################################################
# X-Debug:
###########################################################################
ARG INSTALL_XDEBUG=true

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apt-get update && apt-get install -yq php8.0-xdebug \
;fi
# Set working directory
WORKDIR /var/www/html

COPY ./docker/php/cmd.sh /usr/local/bin/cmd
RUN chmod 775 /usr/local/bin/cmd

# Copy cron SCHEDULE
COPY ./docker/php/cron/schedule.cron /etc/cron.d/schedule.cron
RUN crontab -u www-data /etc/cron.d/schedule.cron && \
    chmod u+s /usr/sbin/cron

# Websocket Container Supervisor + Logs
RUN touch /var/log/websocket.log && \
    chown www-data /var/log/websocket.log && \
    chmod 755 /var/log/websocket.log && \
    touch /var/log/cache_watcher.log && \
    chown www-data /var/log/cache_watcher.log && \
    chmod 755 /var/log/cache_watcher.log
COPY ./docker/php/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

CMD ["/usr/local/bin/cmd"]
