<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string $date
 *
 * @property Assignment[] $assignments
 * @property Bonus[] $bonuses
 * @property Dismiss[] $dismisses
 * @property Recruit[] $recruits
 * @property Vacation[] $vacations
 */
class Order extends ActiveRecord
{
    public static function create($date)
    {
        $order = new self();
        $order->date = $date;
        return $order;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'date' => Yii::t('app', 'Date'),
        ];
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Bonuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBonuses()
    {
        return $this->hasMany(Bonus::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Dismisses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDismisses()
    {
        return $this->hasMany(Dismiss::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Recruits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecruits()
    {
        return $this->hasMany(Recruit::className(), ['order_id' => 'id']);
    }

    /**
     * Gets query for [[Vacations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacations()
    {
        return $this->hasMany(Vacation::className(), ['order_id' => 'id']);
    }
}
