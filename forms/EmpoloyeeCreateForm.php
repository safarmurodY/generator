<?php

namespace app\forms;

use app\models\Interview;
use yii\base\Model;

class EmpoloyeeCreateForm extends Model
{
    public $first_name;
    public $last_name;
    public $email;
    public $address;
    //------------------//
    public $order_date;
    public $contract_date;
    public $recruit_date;

    private $interview;

    /**
     * @param Interview|null $interview
     * @param array $config
     */
    public function __construct(Interview $interview = null, array $config = [])
    {
        if ($interview){
            $this->interview = $interview;
        }
        parent::__construct($config);
    }

    public function init()
    {
        if ($this->interview){
            $this->last_name = $this->interview->last_name;
            $this->first_name = $this->interview->first_name;
            $this->email = $this->interview->email;
        }
        $this->order_date = date('Y-m-d');
        $this->contract_date = date('Y-m-d');
        $this->recruit_date = date('Y-m-d');
    }

    public function rules(): array
    {
        return [
            [['first_name', 'last_name', 'address'], 'required'],
            [['email'], 'email'],
            [['email', 'first_name', 'last_name', 'address'], 'string', 'max' => 255],
            [['order_date', 'contract_date', 'recruit_date'], 'required'],
            [['order_date', 'contract_date', 'recruit_date'], 'date', 'format' => 'php:Y-m-d',],
        ];
    }

    public function attributeLabels()
    {
        return [
            'order_date' => 'Order Date',
            'contract_date' => 'Contract Date',
            'recruit_date' => 'Recruit Date',
            'address' => 'Address',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
        ];
    }
}