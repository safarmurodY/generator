<?php

namespace app\forms;

use yii\base\Model;

class InterviewInviteForm extends Model
{
    public $date;
    public $first_name;
    public $last_name;
    public $email;

    public function init()
    {
        $this->date = date('Y-m-d');
    }

    public function rules(): array
    {
        return [
            [['date', 'first_name', 'last_name'], 'required'],
            [['date',], 'date', 'format' => 'php:Y-m-d',],
            [['email'], 'email'],
            [['email', 'first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'date' => 'Date',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }
}