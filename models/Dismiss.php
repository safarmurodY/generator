<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dismiss".
 *
 * @property int $id
 * @property int $order_id
 * @property int $employee_id
 * @property string $date
 * @property string $reason
 *
 * @property Employee $employee
 * @property Order $order
 */
class Dismiss extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dismiss';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'employee_id', 'date', 'reason'], 'required'],
            [['order_id', 'employee_id'], 'integer'],
            [['date'], 'safe'],
            [['reason'], 'string'],
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
            'reason' => Yii::t('app', 'Reason'),
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
