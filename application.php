#!/usr/bin/env php
<?php

use Danquah\SolrTester\Command\PingCommand;
use Symfony\Component\Console;
use Symfony\Component\Console\Application;
use Symfony\Component\Yaml\Yaml;

if (PHP_VERSION_ID < 50400) {
	file_put_contents('php://stderr', sprintf(
		"Bazinga Installer requires PHP 5.4 version or higher and your system has\n" .
		"PHP %s version installed.\n\n" .
		"To solve this issue, upgrade your PHP installation or install Symfony manually\n" .
		"executing the following command:\n\n" .
		"composer create-project symfony/framework-standard-edition <project-name> <symfony-version>\n\n",
		PHP_VERSION
	));

	exit(1);
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
	require __DIR__ . '/vendor/autoload.php';
} else {
	echo 'Missing autoload.php, run composer install or composer update.' . PHP_EOL;
	exit(2);
}

	$appVersion = '0.0.1-DEV';

$config_path = __DIR__ . '/Configuration/config.yml';
$config = is_readable($config_path) ? Yaml::parse(file_get_contents($config_path)) : [];

$app = new Application('Some Application', $appVersion);
$app->add(new PingCommand($config));

$app->run();
