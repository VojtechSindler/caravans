<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/others/bdump.php';
$configurator = new Nette\Configurator;
//$configurator->setDebugMode(false);
$configurator->setDebugMode(array("91.229.254.6", "147.230.158.25", "147.230.0.12"));  // debug mode MUST NOT be enabled on production server

//$configurator->setDebugMode();
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor/others')
	->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
Kdyby\Translation\DI\TranslationExtension::register($configurator);
$container = $configurator->createContainer();
return $container;
