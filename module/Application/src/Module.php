<?php

declare(strict_types=1);

namespace Application;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\EventManager\EventInterface;
use Application\Seeder\MovieSeeder;

class Module implements 
    ConfigProviderInterface,
    ServiceProviderInterface,
    BootstrapListenerInterface
{
    public function getConfig(): array
    {
        /** @var array $config */
        $config = include __DIR__ . '/../config/module.config.php';
        return $config;
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                MovieSeeder::class => function($container) {
                    return new MovieSeeder(
                        $container->get('doctrine.entitymanager.orm_default')
                    );
                },
            ],
        ];
    }

    public function onBootstrap(EventInterface $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        // Uncomment the following line when you want to seed the database
        // $serviceManager->get(MovieSeeder::class)->seed();
    }
}