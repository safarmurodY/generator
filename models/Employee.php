<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $address
 * @property string|null $email
 * @property int $status
 *
 * @property Assignment[] $assignments
 * @property Bonus[] $bonuses
 * @property Dismiss[] $dismisses
 * @property Interview[] $interviews
 * @property Recruit[] $recruits
 * @property Vacation[] $vacations
 */
class Employee extends ActiveRecord
{
    const STATUS_PROBATION = 1;
    const STATUS_WORK = 2;
    const STATUS_VACATION = 3;
    const STATUS_DISMISS = 4;

    const SCENARIO_CREATE = 'create';

    public $order_date;
    public $contract_date;
    public $recruit_date;

    public static function getStatusList()
    {
        return [
            self::STATUS_PROBATION => 'Probation',
            self::STATUS_WORK => 'Work',
            self::STATUS_VACATION => 'Vacation',
            self::STATUS_DISMISS => 'Dismiss',
        ];
    }

    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusList(), $this->status);
    }

    public function getFullName()
    {
        return $this->last_name . ' ' . $this->first_name;
    }
    public function afterSave($insert, $changedAttributes)
    {
        if (in_array('status', array_keys($changedAttributes)) && $this->status != $changedAttributes['status']) {
            if ($this->status == self::STATUS_PROBATION) {
//                if ($this->email) {
//                    Yii::$app->mailer->compose('employee/probation', ['model' => $this])
//                        ->setFrom(Yii::$app->params['adminMail'])
//                        ->setTo($this->email)
//                        ->setSubject(' Probation ')
//                        ->send();
//                }
                $log = new Log();
                $log->message = $this->last_name . ' ' . $this->first_name . ' Joined';
                $log->save();
            } elseif ($this->status == self::STATUS_WORK) {
//                if ($this->email) {
//                    Yii::$app->mailer->compose('employee/work', ['model' => $this])
//                        ->setFrom(Yii::$app->params['adminMail'])
//                        ->setTo($this->email)
//                        ->setSubject('You are recruit')
//                        ->send();
//                }
                $log = new Log();
                $log->message = $this->last_name . ' ' . $this->first_name . ' Passed';
                $log->save();
            } elseif ($this->status == self::STATUS_DISMISS) {
//                if ($this->email) {
//                    Yii::$app->mailer->compose('employee/dismiss', ['model' => $this])
//                        ->setFrom(Yii::$app->params['adminMail'])
//                        ->setTo($this->email)
//                        ->setSubject('You are rejected')
//                        ->send();
//                }
                $log = new Log();
                $log->message = $this->last_name . ' ' . $this->first_name . ' Rejected';
                $log->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'address', 'status'], 'required'],
            [['status'], 'integer'],
            [['order_date', 'contract_date', 'recruit_date'], 'required', 'on' => self::SCENARIO_CREATE],
            [['order_date', 'contract_date', 'recruit_date'], 'date', 'on' => self::SCENARIO_CREATE],
            [['first_name', 'last_name', 'address', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'address' => Yii::t('app', 'Address'),
            'email' => Yii::t('app', 'Email'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Assignments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(Assignment::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Bonuses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBonuses()
    {
        return $this->hasMany(Bonus::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Dismisses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDismisses()
    {
        return $this->hasMany(Dismiss::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Interviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInterviews()
    {
        return $this->hasMany(Interview::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Recruits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRecruits()
    {
        return $this->hasMany(Recruit::className(), ['employee_id' => 'id']);
    }

    /**
     * Gets query for [[Vacations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVacations()
    {
        return $this->hasMany(Vacation::className(), ['employee_id' => 'id']);
    }
}
