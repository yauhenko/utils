#!/bin/bash
localedef ru_RU.UTF-8 -i ru_RU -f UTF-8 && \
dpkg-reconfigure tzdata && \
apt update && \
apt upgrade -y && \
add-apt-repository ppa:ondrej/php -y && \
apt install -y software-properties-common apt-utils rsync mc htop dialog nginx curl certbot python3-certbot-nginx && \
apt install -y php7.4-imagick php7.4-fpm php7.4-curl php7.4-xml php7.4-zip php7.4-mbstring php7.4-mysql && \
apt install -y mysql-server && \
echo "CREATE USER 'admin'@'%' IDENTIFIED BY 'yasooshae'; GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION; FLUSH PRIVILEGES;" | mysql && \
curl -sL https://deb.nodesource.com/setup_lts.x | bash && \
apt install -y nodejs && \
npm i -g pm2 && \
curl -sL https://raw.githubusercontent.com/yauhenko/utils/master/install-pma.php | sudo php && \
wget https://raw.githubusercontent.com/yauhenko/utils/master/files.zip -O /tmp/files.zip && \
unzip -o /tmp/files -d / && \
service nginx reload && \
service php7.4-fpm reload

