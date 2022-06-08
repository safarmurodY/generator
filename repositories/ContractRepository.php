<?php

namespace app\repositories;

use app\models\Contract;
use InvalidArgumentException;

class ContractRepository implements ContractRepositoryInterface
{
    /**
     * @param $id
     * @return Contract
     */
    public function find($id): Contract
    {
        if (!$contract = Contract::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $contract;
    }

    /**
     * @param Contract $contract
     * @return void
     * @throws \Throwable
     */
    public function add(Contract $contract): void
    {
        if (!$contract->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $contract->insert(false);
    }

    /**
     * @param Contract $contract
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Contract $contract): void
    {
        if ($contract->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $contract->update(false);
    }
}