<?php

namespace app\bootstrap;

use app\repositories\ContractRepository;
use app\repositories\ContractRepositoryInterface;
use app\repositories\EmployeeRepository;
use app\repositories\EmployeeRepositoryInterface;
use app\repositories\InterviewRepository;
use app\repositories\InterviewRepositoryInterface;
use app\repositories\OrderRepository;
use app\repositories\OrderRepositoryInterface;
use app\repositories\RecruitRepository;
use app\repositories\RecruitRepositoryInterface;
use app\services\Logger;
use app\services\LoggerInterface;
use app\services\Notifier;
use app\services\NotifierInterface;
use Yii;
use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $container = Yii::$container;
        $container->setSingleton(InterviewRepositoryInterface::class, InterviewRepository::class);
        $container->setSingleton(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $container->setSingleton(OrderRepositoryInterface::class, OrderRepository::class);
        $container->setSingleton(ContractRepositoryInterface::class, ContractRepository::class);
        $container->setSingleton(RecruitRepositoryInterface::class, RecruitRepository::class);
        $container->setSingleton(LoggerInterface::class, Logger::class);
        $container->setSingleton(NotifierInterface::class, Notifier::class);
    }
}