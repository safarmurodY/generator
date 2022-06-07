<?php

namespace app\services;

interface NotifierInterface
{
    public function notify($view, $data, $email, $subject);
}