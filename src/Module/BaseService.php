<?php

namespace App\Module;

use App\Core\CATrait;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

abstract class BaseService
{
    use CATrait;

    public function __construct(ManagerRegistry $managerRegistry, ContainerInterface $container)
    {
        $this->initContainer($managerRegistry, $container);
    }
}