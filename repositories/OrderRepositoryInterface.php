<?php

namespace app\repositories;

use app\models\Order;

interface OrderRepositoryInterface
{
    /**
     * @param $id
     * @return Order
     */
    public function find($id): Order;

    /**
     * @param Order $order
     * @return void
     * @throws \Throwable
     */
    public function add(Order $order): void;

    /**
     * @param Order $order
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Order $order): void;
}