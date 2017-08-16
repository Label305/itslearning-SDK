<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\AssignmentContent;
use Itslearning\Objects\Organisation\CourseElementAssignment;
use Itslearning\Requests\Request;

class CreateCourseElementAssignmentRequest implements Request
{

    const CREATE_COURSE_ELEMENT_ASSIGNMENT_MESSAGE_TYPE_NAME = 'Create.Course.Element.Assignment';


    /**
     * @var int
     */
    private $messageTypeIdentifier;
    /**
     * @var CourseElementAssignment
     */
    private $courseElementAssignment;

    /**
     * CreateOrUpdateAppointmentRequest constructor.
     * @param CourseElementAssignment $courseElementAssignment
     * @param int $messageTypeIdentifier
     */
    public function __construct(CourseElementAssignment $courseElementAssignment, int $messageTypeIdentifier)
    {
        $this->courseElementAssignment = $courseElementAssignment;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CourseElementAssignment
     */
    public function execute(ItslearningClient $client): CourseElementAssignment
    {
        $data = $this->map($this->courseElementAssignment);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(CourseElementAssignment $courseElementAssignment)
    {
        $data = [];
        if ($courseElementAssignment->getCourseId() !== null) {
            $data['CourseId'] = $courseElementAssignment->getCourseId();
        };
        if ($courseElementAssignment->getCourseSyncKey() !== null) {
            $data['CourseSyncKey'] = $courseElementAssignment->getCourseSyncKey();
        };
        if ($courseElementAssignment->getParentSyncKey() !== null) {
            $data['ParentSyncKey'] = $courseElementAssignment->getParentSyncKey();
        };
        if ($courseElementAssignment->getUserId() !== null) {
            $data['UserId'] = $courseElementAssignment->getUserId();
        };
        if ($courseElementAssignment->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $courseElementAssignment->getUserSyncKey();
        };
        $data['Title'] = $courseElementAssignment->getTitle();
        if ($courseElementAssignment->getDescription() !== null) {
            $data['Description'] = $courseElementAssignment->getDescription();
        };
        if ($courseElementAssignment->getDeadline() !== null) {
            $data['Deadline'] = $courseElementAssignment->getDeadline();
        };
        if ($courseElementAssignment->getMandatory() !== null) {
            $data['Mandatory'] = $courseElementAssignment->getMandatory() ? 'true' : 'false';
        };
        if ($courseElementAssignment->getAssessment() !== null) {
            $data['Assessment'] = $courseElementAssignment->getAssessment();
        };
        if ($courseElementAssignment->getMaxScore() !== null) {
            $data['MaxScore'] = $courseElementAssignment->getMaxScore();
        };
        if ($courseElementAssignment->getUseGroups() !== null) {
            $data['UseGroups'] = $courseElementAssignment->getUseGroups();
        };
        if ($courseElementAssignment->getPlagiarism() !== null) {
            $data['Plagiarism'] = $courseElementAssignment->getPlagiarism();
        };
        if ($courseElementAssignment->getUseAnonymousSubmission() !== null) {
            $data['UseAnonymousSubmission'] = $courseElementAssignment->getUseAnonymousSubmission();
        };

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($courseElementAssignment->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $courseElementAssignment->getSyncKey()
            ];
        }
        $message['CreateCourseElementAssignment'] = [$data];

        if (count($courseElementAssignment->getFiles()) > 0) {
            $message['Files'] = [
                'File' => $courseElementAssignment->getFiles()
            ];
        }

        return [
            'Message' => $message
        ];
    }

    private function transform($result): CourseElementAssignment
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->courseElementAssignment->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->courseElementAssignment;
    }

}