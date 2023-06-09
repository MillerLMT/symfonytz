<?php

namespace App\Controller\Api;

use App\Controller\BaseController;
use App\Entity\Order;
use App\Module\OrderService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/order")
 */
class OrderController extends BaseController
{
    /**
     * @Route("/", name="api_v2_order")
     * @param Request  $request
     * @return JsonResponse
     */
    public function indexAction(Request $request)
    {
        $result = [];
        switch ($request->getMethod()) {
            case Request::METHOD_GET:
                try {
                    if (!$request->get('id')) {
                        throw new \Exception('Id not found in request');
                    }
                    $order = $this->em->getRepository(Order::class)->find($request->get('id'));
                    $result = ['success' => true, 'order' => $order];
                    if (!$order) {
                        throw new \Exception('Order not found');
                    }
                } catch (\Exception $e) {
                    $result = ['success' => false, 'error' => $e->getMessage()];
                }
                break;
            case Request::METHOD_POST:
                try {
                    if (!$request->get('data')) {
                        throw new \Exception('data for create not found in request');
                    }
                    $order = $this->sc->get(OrderService::class)->createOrder($request->get('data'));
                    $result = ['success' => true, 'order' => $order];
                } catch (\Exception $e) {
                    $result = ['success' => false, 'error' => $e->getMessage()];
                }
                break;
            case Request::METHOD_PATCH:
                try {
                    if (!$request->get('data')) {
                        throw new \Exception('data for update not found in request');
                    }
                    $order = $this->sc->get(OrderService::class)->updateOrder($request->get('data'));
                    $result = ['success' => true, 'order' => $order];
                } catch (\Exception $e) {
                    $result = ['success' => false, 'error' => $e->getMessage()];
                }
                break;
            case Request::METHOD_DELETE:
                try {
                    if (!$request->get('id')) {
                        throw new \Exception('Id not found in request');
                    }
                    $this->sc->get(OrderService::class)->deleteOrder($request->get('id'));
                    $result = ['success' => true];
                } catch (\Exception $e) {
                    $result = ['success' => false, 'error' => $e->getMessage()];
                }
                break;
        }

        if (!$result) {
            $result = ['success' => false, 'error' => 'Unknown request method'];
        }

        return $this->jsonResponse($result);
    }

    /**
     * @Route("/updateOrderStatus", name="api_v2_update_order_status")
     * @param Request  $request
     * @return JsonResponse
     */
    public function updateOrderStatusAction(Request $request)
    {
            $response = $this->sc->get(OrderService::class)->updateOrderStatus($request->get('data'));

            return $this->jsonResponse($response);
    }
}