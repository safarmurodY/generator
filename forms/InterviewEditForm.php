<?php

namespace app\forms;

use app\models\Interview;
use yii\base\Model;

class InterviewEditForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;

    private $interview;

    public function __construct(Interview $interview, $config = [])
    {
        $this->interview = $interview;
        parent::__construct($config);
    }

    public function init()
    {
        $this->last_name = $this->interview->last_name;
        $this->first_name = $this->interview->first_name;
        $this->email = $this->interview->email;
    }

    public function rules(): array
    {
        return [
            [['first_name', 'last_name'], 'required'],
            [['email'], 'email'],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }
}