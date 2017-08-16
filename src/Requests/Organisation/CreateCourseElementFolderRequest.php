<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\CourseElementFolder;
use Itslearning\Objects\Organisation\FolderContent;
use Itslearning\Requests\Request;

class CreateCourseElementFolderRequest implements Request
{

    const CREATE_COURSE_ELEMENT_FOLDER_MESSAGE_TYPE_NAME = 'Create.Course.Element.Folder';

    /**
     * @var int
     */
    private $messageTypeIdentifier;
    /**
     * @var CourseElementFolder
     */
    private $courseElementFolder;

    /**
     * CreateOrUpdateAppointmentRequest constructor.
     * @param CourseElementFolder $courseElementFolder
     * @param int $messageTypeIdentifier
     */
    public function __construct(CourseElementFolder $courseElementFolder, int $messageTypeIdentifier)
    {
        $this->courseElementFolder = $courseElementFolder;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CourseElementFolder
     */
    public function execute(ItslearningClient $client): CourseElementFolder
    {
        $data = $this->map($this->courseElementFolder);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(CourseElementFolder $courseElementFolder)
    {
        $data = [];
        if ($courseElementFolder->getCourseId() !== null) {
            $data['CourseId'] = $courseElementFolder->getCourseId();
        }
        if ($courseElementFolder->getCourseSyncKey() !== null) {
            $data['CourseSyncKey'] = $courseElementFolder->getCourseSyncKey();
        }
        if ($courseElementFolder->getParentSyncKey() !== null) {
            $data['ParentSyncKey'] = $courseElementFolder->getParentSyncKey();
        }
        if ($courseElementFolder->getUserId() !== null) {
            $data['UserId'] = $courseElementFolder->getUserId();
        }
        if ($courseElementFolder->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $courseElementFolder->getUserSyncKey();
        }
        $data['Title'] = $courseElementFolder->getTitle();
        if ($courseElementFolder->getDescription() !== null) {
            $data['Description'] = $courseElementFolder->getDescription();
        }
        if ($courseElementFolder->getActive() !== null) {
            $data['Active'] = $courseElementFolder->getActive() ? 'true' : 'false';
        }
        $data['Security'] = $courseElementFolder->getSecurity();

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($courseElementFolder->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $courseElementFolder->getSyncKey()
            ];
        }
        $message['CreateCourseElementFolder'] = [$data];

        return [
            'Message' => $message
        ];
    }

    private function transform($result): CourseElementFolder
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->courseElementFolder->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->courseElementFolder;
    }

}