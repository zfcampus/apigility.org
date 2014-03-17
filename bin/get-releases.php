#!/usr/bin/env php
<?php
chdir(__DIR__ . '/../');
$curl = curl_init('https://api.github.com/repos/zfcampus/zf-apigility-skeleton/releases');
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Accept: application/vnd.github.v3+json',
    'User-Agent: apigility-org',
));                                             // Send appropriate headers
curl_setopt($curl, CURLOPT_HEADER, 0);          // do not return headers in output
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  // return data from call

$result = curl_exec($curl);
curl_close($curl);

if (false === $result) {
    file_put_contents('php://stderr', "Unable to fetch releases from GitHub!\n");
    exit(1);
}

file_put_contents('data/releases.json', $result);
file_put_contents('php://stdout', "[DONE] Fetched releases from GitHub!\n");
