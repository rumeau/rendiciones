<?php

$appDir = realpath(__DIR__);

$dbHost = '127.0.0.1';
$dbName = 'myapp_test';
$dbUser = 'travis';
$dbPass = '';

$pattern     = array('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT');
$replacement = array($dbHost, $dbName, $dbUser, $dbPass, '3306');

$template = file_get_contents("$appDir/config/autoload/local.php.dist");
$code = str_replace($pattern, $replacement, $template);
file_put_contents("$appDir/config/autoload/local.php", $code);