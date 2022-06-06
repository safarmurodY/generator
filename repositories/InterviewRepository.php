<?php

namespace app\repositories;

use app\models\Interview;
use yii\base\InvalidArgumentException;

class InterviewRepository
{
    /**
     * @param $id
     * @return Interview
     */
    public function find($id): Interview
    {
        if (!$interview = Interview::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $interview;
    }

    /**
     * @throws \Throwable
     */
    public function add(Interview $interview)
    {
        if (!$interview->isNewRecord) {
            throw new InvalidArgumentException('Model not found');
        }
        $interview->insert(false);
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Interview $interview)
    {
        if ($interview->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $interview->update(false);
    }
}