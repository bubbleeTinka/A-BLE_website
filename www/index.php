<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';


define('APP_PATH', realpath(__DIR__ . '/../app'));

App\Bootstrap::boot()
	->createContainer()
	->getByType(Nette\Application\Application::class)
	->run();
