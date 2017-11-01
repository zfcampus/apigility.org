#!/bin/bash
#######################################################################
# Application preparation
#######################################################################

(
    cd /var/vhosts/apigility.org/htdocs ;

    # Execute a composer installation
    echo "Executing composer" ;
    COMPOSER_HOME=/var/cache/composer composer install --quiet --no-ansi --no-dev --no-interaction --no-progress --no-scripts --no-plugins --optimize-autoloader ;

    if [[ $? -ne 0 ]];then
        echo "[ERROR] composer install failed; check the logs to determine why" 1>&2 ;
        exit 1 ;
    fi;

    # Build
    echo "Building site" ;
    COMPOSER_HOME=/var/cache/composer composer build ;

    if [[ $? -ne 0 ]];then
        echo "[ERROR] composer build failed; check the logs to determine why" 1>&2 ;
        exit 1 ;
    fi
)

echo "[DONE] after-install-www-data.sh"
exit 0
