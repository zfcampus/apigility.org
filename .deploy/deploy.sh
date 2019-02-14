#!/bin/bash
function log_error_and_exit () {
    local LAST_COMMAND=$1
    local LAST_STATUS=$2
    logger "Error running $0; received ${LAST_STATUS} from ${LAST_COMMAND}"
    exit ${LAST_STATUS}
}

echo "[BEGIN] deploy apigility.org"
CHECKOUT_DIR=$(readlink -f $(dirname $0)/..)
echo "- Deployment directory: ${CHECKOUT_DIR}"

(
    cd $CHECKOUT_DIR ;

    # Execute a composer installation
    echo "Executing composer" ;
    COMPOSER_HOME=/var/cache/composer composer install --quiet --no-ansi --no-dev --no-interaction --no-progress --no-scripts --no-plugins --optimize-autoloader ;
    if [ $? != 0 ];then log_error_and_exit composer_install $?; fi ;

    # Build
    echo "Building site" ;
    COMPOSER_HOME=/var/cache/composer composer build ;
    if [ $? != 0 ];then log_error_and_exit composer_build $?; fi ;
)

echo "[DONE] deploy apigility.org"
