FROM ubuntu:22.04


ENV DEBIAN_FRONTEND=noninteractive

# Ρύθμιση της Χρονικής Ζώνης
RUN ln -fs /usr/share/zoneinfo/Europe/Athens /etc/localtime && \
    echo "Europe/Athens" > /etc/timezone && \
    apt-get update && \
    apt-get install -y tzdata && \
    dpkg-reconfigure -f noninteractive tzdata

RUN apt-get update && apt-get install -y \
    apache2 \
    mysql-server \
    python3 \
    python3-pip \
    php \
    php8.1 \
    php-mysql \
    && apt-get clean

COPY ./todo/* /var/www/html
COPY ./scheme.sql /docker-entrypoint-initdb.d/schema.sql

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
EXPOSE 80

# Περιβαλλοντικές μεταβλητές MySQL
ENV MYSQL_ROOT_PASSWORD=rootpassword
ENV MYSQL_DATABASE=todo
ENV MYSQL_USER=todo_user
ENV MYSQL_PASSWORD=password

RUN service mysql start

CMD ["bash"]