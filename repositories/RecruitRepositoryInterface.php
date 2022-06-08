<?php

namespace app\repositories;

use app\models\Recruit;

interface RecruitRepositoryInterface
{
    /**
     * @param $id
     * @return Recruit
     */
    public function find($id): Recruit;

    /**
     * @param Recruit $recruit
     * @return void
     * @throws \Throwable
     */
    public function add(Recruit $recruit): void;

    /**
     * @param Recruit $recruit
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Recruit $recruit): void;
}