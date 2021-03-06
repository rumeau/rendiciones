#!/usr/bin/env bash
 
echo "--- Let's get to work. Installing now. ---"
 
echo "--- Updating packages list ---"
sudo apt-get update
 
echo "--- MySQL time ---"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
 
echo "--- Installing base packages ---"
sudo apt-get install -y vim curl python-software-properties
 
echo "--- Updating packages list ---"
sudo apt-get update
 
echo "--- We want the bleeding edge of PHP ---"
sudo add-apt-repository -y ppa:ondrej/php5
 
echo "--- Updating packages list ---"
sudo apt-get update
 
echo "--- Installing PHP-specific packages ---"
sudo apt-get install -y php5 apache2 php-pear libapache2-mod-php5 php5-curl php5-gd php5-mcrypt php5-intl mysql-server-5.5 php5-mysql git-core
 
echo "--- Installing and configuring Xdebug ---"
sudo apt-get install -y php5-xdebug
 
cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF
 
echo "--- Enabling mod-rewrite ---"
sudo a2enmod rewrite
 
echo "--- Setting document root ---"
sudo rm -rf /var/www
sudo ln -fs /vagrant /var/www
 
 
echo "--- Turn on errors ---"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini
 
sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
 
echo "--- Restarting Apache ---"
sudo service apache2 restart
 
echo "--- Install Composer (PHP package manager) ---"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
 
echo "--- Install PHPUnit through Composer---"
sudo composer global require "phpunit/phpunit=4.1.*"
 
#
# Project specific packages
#
 
echo "--- All done, enjoy! :) ---"