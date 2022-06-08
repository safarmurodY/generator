<?php

namespace app\services;

use app\models\Contract;
use app\models\Employee;
use app\models\Interview;
use app\models\Order;
use app\models\Recruit;
use app\repositories\ContractRepositoryInterface;
use app\repositories\EmployeeRepositoryInterface;
use app\repositories\InterviewRepositoryInterface;
use app\repositories\OrderRepositoryInterface;
use app\repositories\RecruitRepositoryInterface;
use yii\base\InvalidArgumentException;
use yii\web\ServerErrorHttpException;

class StaffService
{
    private $logger;
    private $notifier;
    private $interviewRepository;
    private $employeeRepository;
    private $orderRepository;
    private $contractRepository;
    private $recruitRepository;
    private TransactionManager $transactionManager;

    public function __construct(
        InterviewRepositoryInterface $interviewRepository,
        EmployeeRepositoryInterface $employeeRepository,
        LoggerInterface $logger,
        NotifierInterface $notifier,
        OrderRepositoryInterface $orderRepository,
        ContractRepositoryInterface $contractRepository,
        RecruitRepositoryInterface $recruitRepository,
        TransactionManager $transactionManager,
    )
    {
        $this->interviewRepository = $interviewRepository;
        $this->employeeRepository = $employeeRepository;
        $this->orderRepository = $orderRepository;
        $this->contractRepository = $contractRepository;
        $this->recruitRepository = $recruitRepository;
        $this->logger = $logger;
        $this->notifier = $notifier;
        $this->transactionManager = $transactionManager;
    }


    public function joinToInterview($last_name, $first_name, $email, $date): Interview
    {
        $interview = Interview::create($last_name, $first_name, $email, $date);
        $interview->save(false);
        if ($interview->email) {
            $this->notifier->notify('interview/join', ['model' => $interview], $email, 'Joined to Interview');
        }
        $this->logger->log('Interview ' . $interview->id . ' Created ');
        return $interview;
    }

    public function editInterview($interview_id, $last_name, $first_name, $email)
    {
        $interview = $this->interviewRepository->find($interview_id);
        $interview->editData($last_name, $first_name, $email);
        $this->interviewRepository->save($interview);


        $this->logger->log('Interview ' . $interview->id . ' Updated ');
    }

    public function moveInterview($interview_id, $date)
    {
        $interview = $this->interviewRepository->find($interview_id);
        $interview->move($date);
        $this->interviewRepository->save($interview);
        if ($interview->email) {
            $this->notifier->notify('interview/move', ['model' => $interview], $interview->email, 'Your Interview date changed to ' . $interview->date);
        }
        $this->logger->log('Interview ' . $interview->id . ' Updated ');
    }

    /**
     * @param $interview_id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $address
     * @param $orderDate
     * @param $contractDate
     * @param $recruitDate
     * @return mixed
     * @throws \Throwable
     */
    public function createEmployee($interview_id, $firstName, $lastName, $email, $address, $orderDate, $contractDate, $recruitDate)
    {
        try {
            $interview = $this->interviewRepository->find($interview_id);
        }catch (InvalidArgumentException $e){
            $interview = null;
        }
        $transaction = $this->transactionManager->begin();
        try {
            $employee = Employee::create($firstName, $lastName, $email, $address);
            $this->employeeRepository->add($employee);

            if ($interview){
                $interview->pass($employee->id);
                $this->interviewRepository->save($interview);
            }

            $order = Order::create($orderDate);
            $this->orderRepository->add($order);

            $contract = Contract::create($employee->id, $firstName, $lastName, $contractDate);
            $this->contractRepository->add($contract);
            $recruit = Recruit::create($employee->id, $order->id, $recruitDate);
            $this->recruitRepository->add($recruit);

            $transaction->commit();
        }catch (\Exception $e){
            $transaction->rollBack();
            throw $e;
        }

        if ($employee->email) {
            $this->notifier->notify('employee/probation', ['model' => $interview], $employee->email, 'You are accepted to job ');
        }
        $this->logger->log('Employee ' . $employee->id . ' created ');

        return $employee;
    }

    /**
     * @param $id
     * @param $reason
     * @return void
     */
    public function rejectInterview($id, $reason)
    {
        $interview = $this->interviewRepository->find($id);
        $interview->reject($reason);
        $this->interviewRepository->save($interview);
//        if ($interview->email) {
//            $this->notifier->notify('interview/reject', ['model' => $interview], $interview->email, 'Interview Rejected');
//        }
        $this->logger->log('Interview ' . $interview->id . ' Rejected');
    }


}