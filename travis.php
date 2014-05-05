<?php

$appDir = realpath(__DIR__);

$dbHost = '127.0.0.1';
$dbName = 'myapp_test';
$dbUser = 'travis';
$dbPass = '';

$publicFolders = array(
    "$appDir",
    "$appDir/config/autoload/",
    "$appDir/data/cache/",
    "$appDir/data/config/",
    "$appDir/data/DoctrineModule/cache/",
    "$appDir/data/log/",
    "$appDir/data/log/log.log",
    "$appDir/data/tmpuploads/",
	"$appDir/data/uploads/",
    "$appDir/vendor/",
);

foreach ($publicFolders as $folder) {
	if (!is_dir($folder)) {
		@mkdir($folder);
	}
    $chmod = @chmod($folder, 0777);
    if (!$chmod) {
        $err = error_get_last();
        echo $err['message'] . ' on ' . $err['file'] . ' Line:' . $err['line'] . PHP_EOL;
        break;
    }
}

echo 'Permissions fixed' . PHP_EOL;

$pattern     = array('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT');
$replacement = array($dbHost, $dbName, $dbUser, $dbPass, '3306');

$template = file_get_contents("$appDir/config/autoload/local.php.dist");
$code = str_replace($pattern, $replacement, $template);
file_put_contents("$appDir/config/autoload/local.php", $code);

foreach ($protectFolders as $folder) {
	$chmod = @chmod($folder, 0777);
	if (!$chmod) {
		$err = error_get_last();
		echo $err['message'] . ' on ' . $err['file'] . ' Line:' . $err['line'] . PHP_EOL;
		break;
	}
}