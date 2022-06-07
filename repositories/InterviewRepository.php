<?php

namespace app\repositories;

use app\models\Interview;
use yii\base\InvalidArgumentException;

class InterviewRepository implements InterviewRepositoryInterface
{

    public function find($id)
    {
        if (!$interview = Interview::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $interview;
    }

    public function add(Interview $interview)
    {
        if (!$interview->isNewRecord) {
            throw new InvalidArgumentException('Model not found');
        }
        $interview->insert(false);
    }


    public function save(Interview $interview)
    {
        if ($interview->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $interview->update(false);
    }
}