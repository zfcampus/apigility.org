#!/bin/bash
#######################################################################
# Application preparation
#######################################################################

(
    cd /var/vhosts/apigility.org/htdocs ;

    # Execute a composer installation
    echo "Executing composer" ;
    COMPOSER_HOME=/var/cache/composer composer install --quiet --no-ansi --no-dev --no-interaction --no-progress --no-scripts --no-plugins --optimize-autoloader ;

    # Build
    echo "Building site" ;
    COMPOSER_HOME=/var/cache/composer composer build ;
)

echo "[DONE] after-install-www-data.sh"
exit 0
