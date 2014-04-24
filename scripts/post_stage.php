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
 * - ZS_<PARAMNAME> - will contain value of parameter defined in deployment.xml, as specified by
 *   user during deployment.
 */

require_once 'deph.php';

declare(ticks=1);
$deph = new DepH();

$params = $deph->getParams();

$appDir = $params->get( "ZS_APPLICATION_BASE_DIR" );
if (! $appDir ) {
	$appDir = realpath(__DIR__ . '/../');
	if ( ! $appDir ) {
		$deployment->terminate('ZS_APPLICATION_BASE_DIR is undefined');
	}
}

$log = $deph->get('log');
$log::$logFilePath = $appDir . '/app_deployment.log';
$log->addGuiOutput();
$log->info('Init Rendiciones Config');

$deployment = $deph->getDeployment();



$dbHost = $params->get('DB_HOSTNAME');
if (! $dbHost ) {
	$deployment->terminate('DB_HOSTNAME is undefined');
}

$dbName = $params->get('DB_DATABASE');
if (! $dbName ) {
	$deployment->terminate('DB_DATABASE is undefined');
}
$dbUser = $params->get('DB_USERNAME');
if (! $dbUser) {
	$deployment->terminate('DB_USERNAME is undefined');
}
$dbPass = $params->get('DB_PASSWORD');
if (! $dbPass) {
	$deployment->terminate('DB_PASSWORD is undefined');
}

$log->info('Setting directory permissions');
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
        $deployment->terminate($err['message'] . ' on ' . $err['file'] . ' Line:' . $err['line']);
        break;
    }
}
$log->info('Permissions fixed');

$pattern     = array('DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASS', 'DB_PORT');
$replacement = array($dbHost, $dbName, $dbUser, $dbPass, '3306');

$template = $deph->getTemplate();
$template->write(
    "$appDir/config/autoload/local.php.dist",
    "$appDir/config/autoload/local.php",
    $pattern,
    $replacement
);

$log->info('Running composer');
$shell = $deph->getShell();
$shell->setLog($log);
$shell->exec("export COMPOSER_HOME=/home/www-data/ && echo \$COMPOSER_HOME && cd $appDir && /usr/local/zend/bin/php composer.phar self-update");
$shell->exec("export COMPOSER_HOME=/home/www-data/ && echo \$COMPOSER_HOME && cd $appDir && /usr/local/zend/bin/php composer.phar install");
$log->info('Composer done');

$log->info('Protecting directories');
$protectFolders = array(
		"$appDir",
		"$appDir/config/autoload/",
		"$appDir/data/DoctrineModule/cache/",
		"$appDir/vendor/",
);

foreach ($protectFolders as $folder) {
	$chmod = @chmod($folder, 0777);
	if (!$chmod) {
		$err = error_get_last();
		$deployment->terminate($err['message'] . ' on ' . $err['file'] . ' Line:' . $err['line']);
		break;
	}
}
$log->info('Directories protected');

$log->info('Installation Complete');
