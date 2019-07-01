FROM ubuntu:16.04
MAINTAINER Truong Nhat Minh <minh.truong@bigin.vn>
RUN apt-get update && apt-get -y install language-pack-en-base software-properties-common
RUN export LC_ALL=en_US.UTF-8 && export LANG=en_US.UTF-8 && \
    add-apt-repository ppa:ondrej/php && \
    add-apt-repository -y ppa:nginx/stable && \
    apt-get update && apt-get -y install nginx php7.1 php7.1-cli php7.1-common php7.1-json php7.1-opcache php7.1-pgsql php7.1-mbstring php7.1-mcrypt php7.1-zip php7.1-fpm \
    php7.1-xml php7.2-gd curl \
    git unzip vim && \
    curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    curl -LO https://deployer.org/deployer.phar && mv deployer.phar /usr/local/bin/dep && chmod +x /usr/local/bin/dep && \
    apt-get install -y ssh rsync

# Install php7.1 dev tool + Xdebug
RUN apt-get -y install php7.1-dev && \
    pecl install xdebug
# Add daemon off to nginx conf, it will help docker keep nginx as main process running in the FOREGROUND (Run directly and have the interaction of user)
RUN echo "daemon off;" >> /etc/nginx/nginx.conf
RUN apt-get -y install dos2unix
# Create softlink to /var/www/html
RUN ln -s /var/www/html /app && \
    chown -R www-data:www-data /var/www/html && \
    rm -rf /etc/php/7.1/fpm/php.ini
# Install node to use npm install node_modules
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - && \
    apt-get -y install nodejs
# PHP71-gd support image
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y php7.1-gd
RUN apt-get -y install python-setuptools python-dev build-essential && \
    apt-get -y install supervisor
RUN curl -LO https://deployer.org/deployer.phar && \
    mv deployer.phar /usr/local/bin/dep && \
    chmod +x /usr/local/bin/dep
# COPY init script
USER root
COPY crontab /etc/cron.d/crontab
COPY start-server.sh /home
RUN chmod 755 /home/start-server.sh && \
        dos2unix /home/start-server.sh && \
        apt-get install telnet
WORKDIR /var/www/html
EXPOSE 80 443 9000
# Define mountable directories.
VOLUME ["/etc/nginx/sites-enabled", "/etc/nginx/certs", "/etc/nginx/conf.d", "/var/log/nginx", "/etc/php/7.1/fpm", "/root/start-server.sh", "/var/www/html"]
ENTRYPOINT ["/home/start-server.sh"]
