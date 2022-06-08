<?php

namespace app\repositories;

use app\models\Order;
use InvalidArgumentException;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @param $id
     * @return Order
     */
    public function find($id): Order
    {
        if (!$order = Order::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $order;
    }

    /**
     * @param Order $order
     * @return void
     * @throws \Throwable
     */
    public function add(Order $order): void
    {
        if (!$order->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $order->insert(false);
    }

    /**
     * @param Order $order
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Order $order): void
    {
        if ($order->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $order->update(false);
    }
}