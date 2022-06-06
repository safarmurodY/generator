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
    const SCENARIO_CREATE = 'create';

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

    public function getNextStatusList()
    {
        if ($this->status == self::STATUS_PASS){
            return [
                self::STATUS_PASS => 'Passed',
            ];
        }elseif ($this->status == self::STATUS_REJECT){
            return [
                self::STATUS_PASS => 'Passed',
                self::STATUS_REJECT => 'Rejected',
            ];
        }else{
            return [
                self::STATUS_NEW => 'New',
                self::STATUS_PASS => 'Passed',
                self::STATUS_REJECT => 'Rejected',
            ];
        }
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
        $this->reject_reason = $reason;
        $this->status = self::STATUS_REJECT;
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if (in_array('status', array_keys($changedAttributes)) && $this->status != $changedAttributes['status']) {
            if ($this->status == self::STATUS_NEW) {

            } elseif ($this->status == self::STATUS_PASS) {
//                if ($this->email) {
//                    Yii::$app->mailer->compose('interview/join', ['model' => $this])
//                        ->setFrom(Yii::$app->params['adminMail'])
//                        ->setTo($this->email)
//                        ->setSubject('Passed')
//                        ->send();
//                }
                $log = new Log();
                $log->message = $this->last_name . ' ' . $this->first_name . ' Passed';
                $log->save();
            } elseif ($this->status == self::STATUS_REJECT) {
//                if ($this->email) {
//                    Yii::$app->mailer->compose('interview/join', ['model' => $this])
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
        return 'interview';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date', 'first_name', 'last_name'], 'required'],
            [['status'], 'required', 'except' => self::SCENARIO_CREATE],
            [['status'], 'default', 'value' => self::STATUS_NEW],
            [['reject_reason'], 'required', 'when' => function (self $model) {
                return $model->status == self::STATUS_REJECT;
            }, 'whenClient' => "function(attribute, value){
                    return $('#interview-status').val() == '" . self::STATUS_REJECT . "';
                }"
            ],
            [['date'], 'safe'],
            [['status', 'employee_id'], 'integer', 'except' => self::SCENARIO_CREATE],
            [['reject_reason'], 'string'],
            [['first_name', 'last_name', 'email'], 'string', 'max' => 255],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employee::className(), 'targetAttribute' => ['employee_id' => 'id']],
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
}
