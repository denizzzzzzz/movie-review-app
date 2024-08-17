<?php

use Laminas\Mvc\Application;
use Laminas\Stdlib\ArrayUtils;
use Application\Seeder\MovieSeeder;

// Laad de Composer autoloader
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Initialize the application
    $appConfig = require __DIR__ . '/config/application.config.php';
    if (file_exists(__DIR__ . '/config/development.config.php')) {
        $appConfig = ArrayUtils::merge($appConfig, require __DIR__ . '/config/development.config.php');
    }
    $application = Application::init($appConfig);

    // Get the service manager
    $serviceManager = $application->getServiceManager();

    // Get the entity manager
    $entityManager = $serviceManager->get('doctrine.entitymanager.orm_default');

    // Create and run the seeder
    $seeder = new MovieSeeder($entityManager);
    $seeder->seed();

    echo "Seeding complete!\n";
} catch (\Exception $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}