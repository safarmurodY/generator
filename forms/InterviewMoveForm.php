<?php

namespace app\forms;

use app\models\Interview;
use yii\base\Model;

class InterviewMoveForm extends Model
{
    public $date;
    private $interview;

    public function __construct(Interview $interview, $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        $this->date = $this->interview->date;
    }

    public function rules(): array
    {
        return [
            [['date'], 'required'],
            [['date'], 'date', 'format' => 'php:Y-m-d',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Interview Date',
        ];
    }
}