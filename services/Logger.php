<?php

namespace app\services;

use app\models\Log;

class Logger
{
    public function log($message)
    {
        $log = new Log();
        $log->message = $message;
        $log->save();
    }
}