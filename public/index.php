<?php

// Delegate static file requests back to the PHP built-in webserver
if (PHP_SAPI === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

(function () {
    $appConfig = require __DIR__ . '/../config/application.config.php';
    if (file_exists(__DIR__ . '/../config/development.config.php')) {
        $appConfig = \Zend\Stdlib\ArrayUtils::merge($appConfig, require __DIR__ . '/../config/development.config.php');
    }

    // Run the application!
    \Zend\Mvc\Application::init($appConfig)->run();
})();
