<?php

namespace app\repositories;

use app\models\Employee;
use InvalidArgumentException;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    /**
     * @param $id
     * @return Employee
     */
    public function find($id): Employee
    {
        if (!$employee = Employee::findOne($id)) {
            throw new InvalidArgumentException('Model not found');
        }

        return $employee;
    }

    /**
     * @param Employee $employee
     * @return void
     * @throws \Throwable
     */
    public function add(Employee $employee): void
    {
        if (!$employee->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $employee->insert(false);
    }

    /**
     * @param Employee $employee
     * @return void
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function save(Employee $employee): void
    {
        if ($employee->isNewRecord) {
            throw new InvalidArgumentException('Model not exist');
        }
        $employee->update(false);
    }
}