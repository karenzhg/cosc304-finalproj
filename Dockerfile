FROM php:7.4-apache

WORKDIR /var/www/html/

RUN apt-get update
RUN apt-get -y --no-install-recommends install gnupg2 software-properties-common

RUN curl -sSL https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list

RUN apt-get update

RUN apt-get -y --no-install-recommends install unixodbc-dev \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql18 mssql-tools18
RUN docker-php-ext-install pdo mysqli
RUN pecl install sqlsrv pdo_sqlsrv xdebug
RUN docker-php-ext-enable sqlsrv pdo_sqlsrv xdebug

