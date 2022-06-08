<?php

namespace app\repositories;

use app\models\Contract;

interface ContractRepositoryInterface
{
    /**
     * @param $id
     * @return Contract
     */
    public function find($id): Contract;

    /**
     * @param Contract $contract
     * @return void
     * @throws \Throwable
     */
    public function add(Contract $contract): void;

    /**
     * @param Contract $contract
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Contract $contract): void;
}