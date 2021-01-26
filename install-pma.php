<?php

if(getenv('USER') !== 'root') {
    echo 'This command must be run under ROOT' . PHP_EOL;
    exit(1);
}

system('apt-get install -y nginx php7.4-fpm php7.4-mysql php7.4-curl php7.4-mbstring');
system('rm -rf /opt/pma.zip /opt/pma');
system('wget https://files.phpmyadmin.net/phpMyAdmin/5.0.4/phpMyAdmin-5.0.4-all-languages.zip -O /opt/pma.zip');
chdir('/opt');
system('unzip -o pma.zip');
system('mv phpMyAdmin-5.0.4-all-languages pma');
chdir('pma');
system('cp config.sample.inc.php config.inc.php');
mkdir('tmp');
system('chmod 0777 tmp');

$f = fopen('config.inc.php', 'a');
fwrite($f, PHP_EOL . '$cfg[\'blowfish_secret\'] = \'' . bin2hex(random_bytes(16)) . '\';' . PHP_EOL);
fwrite($f, '$cfg[\'TempDir\'] = __DIR__ . \'/tmp\';' . PHP_EOL);
fclose($f);

file_put_contents('/etc/nginx/conf.d/pma.conf', 'server {
    listen 2108;
    root /opt/pma;
    index index.php;
    location ~ \.php$ {
        include fastcgi.conf;
        fastcgi_pass unix:/run/php/php7.4-fpm.sock;
    }
}
');

system('service nginx reload');
