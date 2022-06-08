<?php

namespace app\repositories;

use app\models\Recruit;
use InvalidArgumentException;

class RecruitRepository implements RecruitRepositoryInterface
{
    /**
     * @param $id
     * @return Recruit
     */
    public function find($id): Recruit
    {
        if (!$recruit = Recruit::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $recruit;
    }

    /**
     * @param Recruit $recruit
     * @return void
     * @throws \Throwable
     */
    public function add(Recruit $recruit): void
    {
        if (!$recruit->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $recruit->insert(false);
    }

    /**
     * @param Recruit $recruit
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Recruit $recruit): void
    {
        if ($recruit->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $recruit->update(false);
    }
}