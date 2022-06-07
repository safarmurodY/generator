<?php

namespace app\services;

use Yii;

class Notifier implements NotifierInterface
{
    public function notify($view, $data, $email, $subject)
    {
        Yii::$app->mailer->compose($view, $data)
            ->setFrom(Yii::$app->params['adminMail'])
            ->setTo($email)
            ->setSubject($subject)
            ->send();
    }
}