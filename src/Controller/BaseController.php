<?php

namespace App\Controller;

use App\Core\CATrait;
use App\Module\CarService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\JsonResponse;


abstract class BaseController extends AbstractController
{
    use CATrait;

    public function __construct(ManagerRegistry $managerRegistry, ContainerInterface $container)
    {
        $this->initContainer($managerRegistry, $container);
    }
    /**
     * Returns a JSON response
     *
     * @param $data
     * @param $status
     * @param array $headers
     * @return JsonResponse
     */
    public function jsonResponse($data, $status = 200, $headers = [])
    {
        return new JsonResponse($data, $status, $headers);
    }
}