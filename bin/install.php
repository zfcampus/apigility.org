#!/usr/bin/env php
<?php
/**
 * Apigility installer
 *
 * http://www.apigility.org
 * (C) 2013-2014 Copyright Zend Technologies Ltd.
 */

$localPath    = __DIR__;
$apigilityDir = 'apigility';
$tmpFile      = sys_get_temp_dir() . '/apigility.zip';
$port         = '8888';

checkPlatform();

if (file_exists($apigilityDir)) {
    die("Error: The apigility directory already exists\n");
}
echo "Download Apigility\n";

$fr = fopen('https://github.com/zfcampus/zf-apigility-skeleton/archive/master.zip', 'r');
$fw = fopen($tmpFile, 'w');
while (!feof($fr)) {
    fwrite($fw, fread($fr, 1024));
    echo '.';
}
fclose($fw);
fclose($fr);

echo "\nInstall Apigility\n";

$zip = new ZipArchive;
if (!$zip->open($tmpFile)) {
    die("Error: opening file $tmpFile\n"); 
}
if (!$zip->extractTo($localPath)) {
    die("Error: extract $tmpFile\n");
}

$dirName = $zip->getNameIndex(0);
$zip->close();

// Rename to apigility
rename($dirName, 'apigility');
// Remove temp file
unlink($tmpFile);

if (strpos(exec("composer -V"), "version") !== false) {
    $composer = 'composer';
} else {
    $composer = 'php composer.phar';
    echo "Get composer.phar\n";
    // Download composer.phar
    file_put_contents("$apigilityDir/composer.phar",
        file_get_contents('https://getcomposer.org/composer.phar'));
}
chdir($apigilityDir);

// Install composer
passthru("$composer install");

echo "Enable development mode\n";
$result = exec("php public/index.php development enable");
if (strpos($result, "development mode") === false) {
    die("Error: I cannot switch Apigility to development mode\n");
}
echo "Installation complete.\n";
if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
    echo "Running PHP internal web server.\n";
    echo "Open your browser to http://localhost:$port, Ctrl-C to stop it.\n";
    exec("php -S 0:$port -t public public/index.php");
} else {
    echo "I cannot execute the PHP internal web server, because you are running PHP < 5.4.\n";
    echo "You need to configure a web server to point the 'apigility/public' folder\n";
}

/**
 * Check for platform requirements
 *
 * @return void
 */
function checkPlatform()
{
    if (!class_exists('ZipArchive')) {
        die("Error: I cannot install Apigility without the Zip extension of PHP\n");
    }
}
