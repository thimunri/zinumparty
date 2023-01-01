FROM alpine:3.15

# env vars
ENV NEW_RELIC_ENABLED=true
ENV NR_INSTALL_USE_CP_NOT_LN=1
ENV NR_INSTALL_SILENT=1

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-zip php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-xmlwriter php7-ctype \
    php7-mbstring php7-gd php7-session php7-pdo php7-pdo_mysql php7-tokenizer php7-posix \
    php7-fileinfo php7-opcache php7-cli php7-mcrypt php7-pcntl php7-iconv php7-simplexml php7-bcmath \
    nginx curl vim supervisor

# Install fluent-bit
#RUN apk add fluent-bit --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/testing/

# Install monitoring tools
WORKDIR /opt
RUN export NEWRELIC_VERSION="$(curl -sS https://download.newrelic.com/php_agent/release/ | sed -n 's/.*>\(.*linux-musl\).tar.gz<.*/\1/p')" \
    && curl -fSL https://download.newrelic.com/php_agent/release/${NEWRELIC_VERSION}.tar.gz \
    -o nr-php-agent.tar.gz \
    && tar zxf nr-php-agent.tar.gz \
    && newrelic-php5-*/newrelic-install install

# Copy scripts
WORKDIR /
COPY ./env/scripts/entrypoint.sh /etc
RUN chmod +x /etc/entrypoint.sh

# Configure nginx
COPY ./env/config/nginx.conf /etc/nginx/nginx.conf

# Configure supervisord
COPY ./env/config/supervisord.ini /etc/supervisor.d/base.ini

# Configure PHP-FPM
COPY ./env/config/fpm-www.conf /etc/php7/php-fpm.d/www.conf
COPY ./env/config/conf-php.ini /etc/php7/conf.d/custom.ini
COPY ./env/config/conf-newrelic.ini /etc/php7/conf.d/newrelic.ini

# Configure fluent-bit
#COPY ./env/config/fluent-bit.conf /etc/fluent-bit/fluent-bit.conf

# Configure composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

EXPOSE 80 443
CMD ["/etc/entrypoint.sh"]
