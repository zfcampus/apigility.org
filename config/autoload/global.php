<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
	'apigility' => array(
		'version' => '0.9.1'
	),
    'links' => array(
		'zip' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/download/0.9.1/zf-apigility-skeleton-0.9.1.zip',
    	'tgz' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/download/0.9.1/zf-apigility-skeleton-0.9.1.tgz',
    	'forkme' => 'https://github.com/zfcampus'
	)
);