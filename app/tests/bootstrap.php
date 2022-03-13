<?php

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}


function bootstrap(): void
{
    $kernel = new Kernel('test', true);
    $kernel->boot();

    $application = new Application($kernel);
    $application->setAutoExit(false);

    $application->run(new ArrayInput([
        'command' => 'doctrine:database:drop',
        '--if-exists' => '1',
        '--force' => '1',
        '--env' => 'test'
    ]));

    $application->run(new ArrayInput([
        'command' => 'doctrine:database:create',
        '--env' => 'test'
    ]));

    $application->run(new ArrayInput([
        'command' => 'doctrine:migrations:migrate',
        '--env' => 'test',
        '--no-interaction' => '1'
    ]));


    $application->run(new ArrayInput([
        'command' => 'doctrine:fixtures:load',
        '--env' => 'test',
        '--no-interaction' => '1'
    ]));

    $kernel->shutdown();
}

bootstrap();