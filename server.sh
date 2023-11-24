# sudo apt-get update; sudo apt-get install apache2 vim curl git-core
# git clone https://github.com/WGMM-Varejista/wgmm-erp.git
sudo apt-get install php7.4
sudo apt-get install php7.4-curl php7.4-gd php7.4-mysql php7.4-zip php7.4-json php7.4-xml php7.4-bcmath
sudo apt-get install openssl
sudo apt-get update
sudo apt-get install libapache2-mod-php7.4
sudo apt-get install mysql-server-8.0
sudo a2enmod rewrite
service apache2 restart
sudo mysql -u root -p
mysql -u admin -p
sudo apt-get install phpmyadmin
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo apt-get install zip unzip
sudo vi /etc/apache2/apache2.conf
service apache2 restart
cd /var/www/wgmm-erp/
vi /etc/apache2/sites-available/000-default.conf
service apache2 restart
cp .env.example .env
vi .env
composer i
chmod -R 777 storage
php artisan migrate
php artisan key:generate