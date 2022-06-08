<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "interview".
 *
 * @property int $id
 * @property string $date
 * @property string $first_name
 * @property string $last_name
 * @property string|null $email
 * @property int $status
 * @property string|null $reject_reason
 * @property int|null $employee_id
 *
 * @property Employee $employee
 */
class Interview extends ActiveRecord
{

    const STATUS_NEW = 1;
    const STATUS_PASS = 2;
    const STATUS_REJECT = 3;

    public static function getStatusList()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_PASS => 'Passed',
            self::STATUS_REJECT => 'Rejected',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }


    public static function create($last_name, $first_name, $email, $date): Interview
    {
        $interview = new Interview();
        $interview->date = $date;
        $interview->last_name = $last_name;
        $interview->first_name = $first_name;
        $interview->email = $email;
        $interview->status = Interview::STATUS_NEW;
        return $interview;
    }
    public function editData($last_name, $first_name, $email)
    {
        $this->last_name = $last_name;
        $this->first_name = $first_name;
        $this->email = $email;
    }
    public function reject($reason)
    {
        $this->guardNotRejected();
        $this->reject_reason = $reason;
        $this->status = self::STATUS_REJECT;
    }
    public function pass($employee_id)
    {
        $this->guardNotPass();
        $this->employee_id = $employee_id;
        $this->status = self::STATUS_PASS;
    }

    public function move($date)
    {
        $this->guardNotCurrentDate($date);
        $this->date = $date;
    }


    public function isRecruitable(): bool
    {
        return $this->status == self::STATUS_NEW;
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'interview';
    }



    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
            'reject_reason' => Yii::t('app', 'Reject Reason'),
            'employee_id' => Yii::t('app', 'Employee ID'),
        ];
    }

    /**
     * Gets query for [[Employee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employee::className(), ['id' => 'employee_id']);
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name;
    }


    private function guardNotRejected()
    {
        if ($this->status == self::STATUS_REJECT){
            throw new \DomainException('Already rejected');
        }
    }

    private function guardNotCurrentDate($date)
    {
        if($this->date == $date){
            throw new \DomainException('Inserted date is equal with before one');
        }
    }

    private function guardNotPass()
    {
        if ($this->status == self::STATUS_PASS)
            throw new \DomainException('Already Passed');
    }
}
