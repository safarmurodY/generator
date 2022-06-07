<?php

namespace app\repositories;

use app\models\Interview;

interface InterviewRepositoryInterface
{

    public function find($id);

    public function add(Interview $interview);

    public function save(Interview $interview);
}