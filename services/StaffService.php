<?php

namespace app\services;

use app\models\Interview;
use app\repositories\InterviewRepositoryInterface;

class StaffService
{
    private $interviewRepository;
    private $logger;
    private $notifier;

    public function __construct(InterviewRepositoryInterface $interviewRepository, LoggerInterface $logger, NotifierInterface $notifier)
    {
        $this->interviewRepository = $interviewRepository;
        $this->logger = $logger;
        $this->notifier = $notifier;
    }


    public function joinToInterview($last_name, $first_name, $email, $date): Interview
    {
        $interview = Interview::create($last_name, $first_name, $email, $date);
        $interview->save(false);
//        if ($interview->email) {
//            $this->notifier->notify('interview/join', ['model' => $interview], $email, 'Joined to Interview');
//        }
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
//        if ($interview->email) {
//            $this->notifier->notify('interview/move', ['model' => $interview], $email, 'Your Interview date changed to ' . $interview->date);
//        }
        $this->logger->log('Interview ' . $interview->id . ' Updated ');
    }

    public function createEmployee($firstName, $lastName, $email, $orderDate, $contractDate, $recruitDate)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($interview){
                $interview->status = Interview::STATUS_PASS;
                $interview->save();
            }
            $model->save(false);
            $order = new Order();
            $order->date = $model->order_date;
            $order->save(false);

            $contract = new Contract();
            $contract->employee_id = $model->id;
            $contract->first_name = $model->first_name;
            $contract->last_name = $model->last_name;
            $contract->date_open = $model->contract_date;
            $contract->save(false);

            $recruit = new Recruit();
            $recruit->employee_id = $model->id;
            $recruit->order_id = $order->id;
            $recruit->date = $model->recruit_date;
            $recruit->save(false);

            $transaction->commit();
            \Yii::$app->session->setFlash('success', 'Employee Recruit');
            return $this->redirect(['view', 'id' => $model->id]);

        }catch (\Exception $e){
            $transaction->rollBack();
            throw new ServerErrorHttpException($e->getMessage());
        }
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