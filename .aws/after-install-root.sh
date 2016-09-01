#!/bin/bash
#######################################################################
# System preparation for application post-installation
#######################################################################

echo "Ensuring www-data owns apigility.org install and can write to it"
chown -R www-data.www-data /var/vhosts/apigility.org/htdocs
chown -R ug+rwX /var/vhosts/apigility.org/htdocs

echo "[DONE] after-install-root.sh"
