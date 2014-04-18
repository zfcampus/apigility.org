<?php
/* The script post_stage.phpwill be executed after the staging process ends. This will allow
 * users to perform some actions on the source tree or server before an attempt to
 * activate the app is made. For example, this will allow creating a new DB schema
 * and modifying some file or directory permissions on staged source files
 * The following environment variables are accessable to the script:
 * 
 * - ZS_RUN_ONCE_NODE - a Boolean flag stating whether the current node is
 *   flagged to handle "Run Once" actions. In a cluster, this flag will only be set when
 *   the script is executed on once cluster member, which will allow users to write
 *   code that is only executed once per cluster for all different hook scripts. One example
 *   for such code is setting up the database schema or modifying it. In a
 *   single-server setup, this flag will always be set.
 * - ZS_WEBSERVER_TYPE - will contain a code representing the web server type
 *   ("IIS" or "APACHE")
 * - ZS_WEBSERVER_VERSION - will contain the web server version
 * - ZS_WEBSERVER_UID - will contain the web server user id
 * - ZS_WEBSERVER_GID - will contain the web server user group id
 * - ZS_PHP_VERSION - will contain the PHP version Zend Server uses
 * - ZS_APPLICATION_BASE_DIR - will contain the directory to which the deployed
 *   application is staged.
 * - ZS_CURRENT_APP_VERSION - will contain the version number of the application
 *   being installed, as it is specified in the package descriptor file
 * - ZS_PREVIOUS_APP_VERSION - will contain the previous version of the application
 *   being updated, if any. If this is a new installation, this variable will be
 *   empty. This is useful to detect update scenarios and handle upgrades / downgrades
 *   in hook scripts
 */  
