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

return [
    'apigility' => [
        'version' => '1.4.0'
    ],
    'links' => [
        'zip' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/download/1.4.0/zf-apigility-skeleton-1.4.0.zip',
        'tgz' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/download/1.4.0/zf-apigility-skeleton-1.4.0.tgz',
        'forkme' => 'https://github.com/zfcampus'
    ]
];
