<?php

namespace app\bootstrap;

use app\repositories\InterviewRepository;
use app\repositories\InterviewRepositoryInterface;
use app\services\Logger;
use app\services\LoggerInterface;
use app\services\Notifier;
use app\services\NotifierInterface;
use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton('app\repositories\InterviewRepositoryInterface', 'app\repositories\InterviewRepository');
        $container->setSingleton(LoggerInterface::class, Logger::class);
        $container->setSingleton(NotifierInterface::class, Notifier::class);
    }
}