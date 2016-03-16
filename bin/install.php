<?php
/**
 * Apigility installer
 *
 * @see http://www.apigility.org
 * (C) 2013-2014 Copyright Zend Technologies Ltd.
 */

$localPath    = __DIR__;
$apigilityDir = 'apigility';
$port         = '8888';
$releaseUrl   = 'https://github.com/zfcampus/zf-apigility-skeleton/releases/download/1.3.3/zf-apigility-skeleton-1.3.3.zip';
$tmpFile      = sys_get_temp_dir() . '/apigility_' . md5($releaseUrl) . '.zip';

checkPlatform();

if (file_exists($apigilityDir)) {
    die("Error: The apigility directory already exists\n");
}

if (!file_exists($tmpFile)) {
	echo "Download Apigility\n";
	$fr = fopen($releaseUrl, 'r');
	$fw = fopen($tmpFile, 'w');
	while (!feof($fr)) {
	    fwrite($fw, fread($fr, 1048576)); // 1 MB buffer
	    echo '.';
	}
	fclose($fw);
	fclose($fr);
} else  {
	echo "Get Apigility from cache [$tmpFile]";
}

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

// Change directory to apigility
chdir($apigilityDir);

echo "Installation complete.\n";
if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
    echo "Running PHP internal web server.\n";
    echo "Open your browser to http://localhost:$port, Ctrl-C to stop it.\n";
    exec("php -S 0.0.0.0:$port -ddisplay_errors=0 -t public public/index.php");
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
