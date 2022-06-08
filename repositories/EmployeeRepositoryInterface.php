<?php

namespace app\repositories;

use app\models\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * @param $id
     * @return Employee
     */
    public function find($id): Employee;

    /**
     * @param Employee $employee
     * @return void
     * @throws \Throwable
     */
    public function add(Employee $employee): void;

    /**
     * @param Employee $employee
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Employee $employee): void;
}