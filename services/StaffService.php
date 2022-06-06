<?php

namespace app\services;

use app\models\Interview;
use app\models\Log;
use app\repositories\InterviewRepository;
use Yii;
use yii\base\InvalidArgumentException;

class StaffService
{
    private $interviewRepository;
    private $logger;
    private $notifier;
    public function __construct(
        InterviewRepository $interviewRepository,
        Logger $logger,
        Notifier $notifier
    )
    {
        $this->interviewRepository = $interviewRepository;
        $this->logger = $logger;
        $this->notifier = $notifier;
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
        if ($interview->email) {
            $this->notifier->notify('interview/reject', ['model' => $interview], $interview->email, 'Interview Rejected');
        }
        $this->logger->log('Interview ' . $interview->id . ' Rejected');
    }


}