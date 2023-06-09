<?php

namespace App\Module;

use App\Entity\Enum\OrderStatusEnum;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;

/**
 * @DI\Service("order_service")
 */
class OrderService extends BaseService
{
    public function createOrder($data)
    {
        $order = new Order();

        [$amount, $totalAmount] = $this->calcOrderData($data);

        $order->setCurrency('RUB')
            ->setAmount($amount)
            ->setTotalAmount($totalAmount)
            ->setCreatedAt(new \DateTime())
            ->setUpdatedAt(new \DateTime())
            ->setStatus(OrderStatusEnum::ORDER_CREATED);

        $this->em->persist($order);
        $this->em->flush();

        $this->createOrderPositions($data, $order);

        return $order;
    }

    public function updateOrder($data)
    {
        $order = $this->em->getRepository(Order::class)->find($data['orderId']);

        $this->updateOrderItems($data['items'], $order);

        [$amount, $totalAmount] = $this->calcOrderData($data['items']);

        $order->setAmount($amount);
        $order->setTotalAmount($totalAmount);
        $order->setUpdatedAt(new \DateTime());
        $order->setStatus(OrderStatusEnum::ORDER_UPDATED);
        $this->em->flush();

        return $order;
    }

    public function calcOrderData($data)
    {
        $amount = 0;
        $totalAmount = 0;

        foreach ($data as $item) {
            $product = $this->em->getRepository(Product::class)->find($item['productId']);
            $quantity = $item['qty'];

            $amount += $product->getPrice() * $quantity;
            $totalAmount += $product->getPrice() * $quantity;
        }

        return [$amount, $totalAmount];
    }

    public function createOrderPositions($data, $order)
    {
        foreach ($data as $item)
        {
           $product = $this->em->getRepository(Product::class)->find($item['productId']);
           $quantity = $item['qty'];

           $amount = $product->getPrice() * $quantity;

           $orderItem = new OrderItem();

           $orderItem->setOrder($order)
                ->setProduct($product)
                ->setCount($quantity)
                ->setAmount($amount);

           $this->em->persist($orderItem);
           $this->em->flush();

        }
    }

    public function updateOrderItems($items, $order)
    {
        $orderItems = $this->em->getRepository(OrderItem::class)->findBy(['order' => $order]);

        $itemsIds = [];
        foreach ($items as $item) {
            if ($item['orderItemId']) {
                $itemsIds[$item['orderItemId']] = 1;
                /** @var OrderItem $orderItem */
                $orderItem = $this->em->getRepository(OrderItem::class)->find($item['orderItemId']);
                $orderItem->setCount($item['qty']);
                $productPrice = $orderItem->getProduct()->getPrice();
                $orderItem->setAmount($productPrice * $item['qty']);
            } else {
                $product = $this->em->getRepository(Product::class)->find($item['productId']);
                $amount = $product->getPrice() * $item['qty'];
                $orderItem = new OrderItem();
                $orderItem->setProduct($product)
                    ->setOrder($order)
                    ->setCount($item['qty'])
                    ->setAmount($amount);

                $this->em->persist($orderItem);
                $this->em->flush();
            }
        }

        foreach ($orderItems as $orderItem) {
            if (!array_key_exists($orderItem->getId(), $itemsIds)) {
                $this->em->remove($orderItem);
                $this->em->flush();
            }
        }

        $this->em->flush();
    }

    public function updateOrderStatus($data)
    {
        if (!$data['orderId']) {
            return ['success' => false, 'error' => 'Order id not found at request'];
        }

        if (!$data['status']) {
            return ['success' => false, 'error' => 'Status not found at request'];
        }

        $order = $this->em->getRepository(Order::class)->find($data['orderId']);

        if (!$order) {
            return ['success' => false, 'error' => 'Order not found'];
        }

        $order->setStatus($data['status']);
        $order->setUpdatedAt(new \DateTime());
        $this->em->flush();

        return ['success' => true, 'order' => $order];
    }

    public function deleteOrder($orderId)
    {
        $order = $this->em->getRepository(Order::class)->find($orderId);
        $this->em->remove($order);
        $this->em->flush();
    }
}