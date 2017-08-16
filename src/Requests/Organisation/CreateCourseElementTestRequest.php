<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\ItslearningException;
use Itslearning\Objects\Organisation\CourseElementTest;
use Itslearning\Requests\Request;

class CreateCourseElementTestRequest implements Request
{

    const CREATE_COURSE_ELEMENT_TEST_MESSAGE_TYPE_NAME = 'Create.Course.Element.Test';


    /**
     * @var int
     */
    private $messageTypeIdentifier;
    /**
     * @var CourseElementTest
     */
    private $courseElementTest;

    /**
     * CreateOrUpdateAppointmentRequest constructor.
     * @param CourseElementTest $courseElementTest
     * @param int $messageTypeIdentifier
     */
    public function __construct(CourseElementTest $courseElementTest, int $messageTypeIdentifier)
    {
        $this->courseElementTest = $courseElementTest;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CourseElementTest
     */
    public function execute(ItslearningClient $client): CourseElementTest
    {
        $data = $this->map($this->courseElementTest);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(CourseElementTest $courseElementTest)
    {
        $data = [];


        if ($courseElementTest->getCourseId() !== null) {
            $data['CourseId'] = $courseElementTest->getCourseId();
        }
        if ($courseElementTest->getCourseSyncKey() !== null) {
            $data['CourseSyncKey'] = $courseElementTest->getCourseSyncKey();
        }
        if ($courseElementTest->getParentSyncKey() !== null) {
            $data['ParentSyncKey'] = $courseElementTest->getParentSyncKey();
        }
        if ($courseElementTest->getActive() !== null) {
            $data['Active'] = $courseElementTest->getActive();
        }
        if ($courseElementTest->getUserId() !== null) {
            $data['UserId'] = $courseElementTest->getUserId();
        }
        if ($courseElementTest->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $courseElementTest->getUserSyncKey();
        }
        $data['Title'] = $courseElementTest->getTitle();
        if ($courseElementTest->getDescription() !== null) {
            $data['Description'] = $courseElementTest->getDescription();
        }
        if ($courseElementTest->getDeadline() !== null) {
            $data['Deadline'] = $courseElementTest->getDeadline();
        }
        if ($courseElementTest->getAssessment() !== null) {
            $data['Assessment'] = $courseElementTest->getAssessment();
        }
        if ($courseElementTest->getUseScore() !== null) {
            $data['UseScore'] = $courseElementTest->getUseScore();
        }
        if ($courseElementTest->getMandatory() !== null) {
            $data['Mandatory'] = $courseElementTest->getMandatory();
        }
        if ($courseElementTest->getScoringMethod() !== null) {
            $data['ScoringMethod'] = $courseElementTest->getScoringMethod();
        }
        if ($courseElementTest->getCompletionCriteria() !== null) {
            $data['CompletionCriteria'] = $courseElementTest->getCompletionCriteria();
        }
        if ($courseElementTest->getOrder() !== null) {
            $data['Order'] = $courseElementTest->getOrder();
        }
        if ($courseElementTest->getMaxTime() !== null) {
            $data['MaxTime'] = $courseElementTest->getMaxTime();
        }
        if ($courseElementTest->getShowResults() !== null) {
            $data['ShowResults'] = $courseElementTest->getShowResults();
        }
        if ($courseElementTest->getShowFeedback() !== null) {
            $data['ShowFeedback'] = $courseElementTest->getShowFeedback();
        }

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($courseElementTest->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $courseElementTest->getSyncKey()
            ];
        }
        $message['CreateCourseElementTest'] = [$data];
        $message['Files'] = [
            'File' => $courseElementTest->getFiles()
        ];

        return [
            'Message' => $message
        ];
    }

    private function transform($result): CourseElementTest
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->courseElementTest->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->courseElementTest;
    }

}