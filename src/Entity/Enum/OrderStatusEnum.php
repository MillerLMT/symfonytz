<?php

namespace App\Entity\Enum;

class OrderStatusEnum
{
    const ORDER_CREATED = 10;
    const ORDER_UPDATED = 20;
    const ORDER_CONFIRMED = 30;
    const ORDER_REJECTED = 40;

    public static $list = [
        self::ORDER_CREATED => 'Заказ создан',
        self::ORDER_UPDATED => 'Заказ обновлен',
        self::ORDER_CONFIRMED => 'Заказ подтвержден',
        self::ORDER_REJECTED => 'Заказ отменен'
    ];
}
