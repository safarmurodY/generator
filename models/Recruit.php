<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "recruit".
 *
 * @property int $id
 * @property int $order_id
 * @property int $employee_id
 * @property string $date
 *
 * @property Employee $employee
 * @property Order $order
 */
class Recruit extends ActiveRecord
{

    public static function create($orderId, $employeeId, $date)
    {
        $recruit = new self();
        $recruit->order_id = $orderId;
        $recruit->employee_id = $employeeId;
        $recruit->date = $date;
        return $recruit;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recruit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'employee_id', 'date'], 'required'],
            [['order_id', 'employee_id'], 'integer'],
            [['date'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'employee_id' => Yii::t('app', 'Employee ID'),
            'date' => Yii::t('app', 'Date'),
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

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
