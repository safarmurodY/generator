<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $first_name
 * @property string $last_name
 * @property string $date_open
 * @property string|null $date_close
 * @property string|null $close_reason
 */
class Contract extends \yii\db\ActiveRecord
{

    public static function create($employeeId, $firstName, $lastName, $date)
    {
        $contract = new self();
        $contract->employee_id = $employeeId;
        $contract->first_name = $firstName;
        $contract->last_name = $lastName;
        $contract->date_open = $date;
        return $contract;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'first_name', 'last_name', 'date_open'], 'required'],
            [['employee_id'], 'integer'],
            [['date_open', 'date_close'], 'safe'],
            [['close_reason'], 'string'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'date_open' => Yii::t('app', 'Date Open'),
            'date_close' => Yii::t('app', 'Date Close'),
            'close_reason' => Yii::t('app', 'Close Reason'),
        ];
    }
}
