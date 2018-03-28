#!/bin/bash
#######################################################################
# System dependencies
#######################################################################

# Install needed dependencies
echo "Updating system dependencies"
apt-get update
apt-get install -y nginx php7.1 php7.1-cli php7.1-common php7.1-fpm php7.1-curl php7.1-json php7.1-mbstring php7.1-readline php7.1-sqlite3 php7.1-xml php7.1-xsl php7.1-zip nodejs-legacy npm

# Get Composer, and install to /usr/local/bin
if [ ! -f "/usr/local/bin/composer" ];then
    echo "Installing composer"
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    php -r "unlink('composer-setup.php');"
else
    echo "Updating composer"
    /usr/local/bin/composer self-update -q --stable --no-ansi --no-interaction
fi

# Create a COMPOSER_HOME directory for the application
if [ ! -d "/var/cache/composer" ];then
    echo "Creating composer cache directory"
    mkdir -p /var/cache/composer
    chown www-data.www-data /var/cache/composer
fi

# Install gulp globally
if [ ! -f "/usr/local/bin/gulp" ];then
    echo "Installing gulp"
    npm install -g gulp
else
    echo "Updating gulp"
    npm update -g gulp
fi

# Ensure we can run npm as www-data
if [ ! -d "/var/www/.npm" ];then
    echo "Ensuring www-data may run npm"
    mkdir -p /var/www/.npm
    chown www-data.www-data /var/www/.npm
    chmod o-X /var/www/.npm
    chmod ug+rwX /var/www/.npm
fi

echo "[DONE] before-install.sh"
exit 0
