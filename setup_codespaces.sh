#!/bin/bash
set -e

# Root MySQL password di Codespaces
MYSQL_ROOT_PASSWORD="admin"

echo "=== Update apt ==="
sudo apt update

echo "=== Install Apache, PHP, MySQL, phpMyAdmin, driver MySQL ==="
sudo DEBIAN_FRONTEND=noninteractive apt install -y apache2 php php-cli php-mysql mysql-server phpmyadmin

echo "=== Tambahkan konfigurasi phpMyAdmin ke Apache ==="
if ! grep -q "phpmyadmin" /etc/apache2/apache2.conf; then
    echo 'Include /etc/phpmyadmin/apache.conf' | sudo tee -a /etc/apache2/apache2.conf
fi

echo "=== Pastikan direktori socket MySQL ada ==="
sudo mkdir -p /var/run/mysqld
sudo chown mysql:mysql /var/run/mysqld

echo "=== Restart MySQL & Apache ==="
sudo service mysql restart
sudo service apache2 restart



echo "=== Buat user MySQL 'admin' ==="
sudo mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY 'admin';"
sudo mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%' WITH GRANT OPTION;"
sudo mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "FLUSH PRIVILEGES;"

echo "=== Buat database Laravel 'laravel' ==="
sudo mysql -u root -p${MYSQL_ROOT_PASSWORD} -e "CREATE DATABASE IF NOT EXISTS laravel;"

echo "=== Update phpMyAdmin config ==="
PHPMA_CONF="/etc/phpmyadmin/config.inc.php"
if ! grep -q "\$cfg\['Servers'\]\[\$i\]\['host'\]" $PHPMA_CONF; then
    echo "<?php
\$i = 1;
\$cfg['Servers'][\$i]['host'] = '127.0.0.1';
\$cfg['Servers'][\$i]['user'] = 'admin';
\$cfg['Servers'][\$i]['password'] = 'admin';
\$cfg['Servers'][\$i]['auth_type'] = 'config';
?>" | sudo tee $PHPMA_CONF
fi

echo "=== Restart Apache ==="
sudo service apache2 restart

echo "=== Selesai! ==="
echo "phpMyAdmin login: admin/admin"
echo "Laravel .env bisa pakai:"
echo "DB_CONNECTION=mysql"
echo "DB_HOST=127.0.0.1"
echo "DB_PORT=3306"
echo "DB_DATABASE=laravel"
echo "DB_USERNAME=admin"
echo "DB_PASSWORD=admin"
