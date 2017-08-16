<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\ItslearningException;
use Itslearning\Objects\Organisation\ContentBlockSet;
use Itslearning\Objects\Organisation\CourseElementPage;
use Itslearning\Objects\Organisation\FileContent;
use Itslearning\Objects\Organisation\PageContent;
use Itslearning\Objects\Organisation\TextContentBlock;
use Itslearning\Requests\Request;

class CreateCourseElementPageRequest implements Request
{

    const CREATE_COURSE_ELEMENT_PAGE_MESSAGE_TYPE_NAME = 'Create.Course.Element.Page';


    /**
     * @var int
     */
    private $messageTypeIdentifier;
    /**
     * @var CourseElementPage
     */
    private $courseElementPage;

    /**
     * CreateOrUpdateAppointmentRequest constructor.
     * @param CourseElementPage $courseElementPage
     * @param int $messageTypeIdentifier
     */
    public function __construct(CourseElementPage $courseElementPage, int $messageTypeIdentifier)
    {
        $this->courseElementPage = $courseElementPage;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return CourseElementPage
     */
    public function execute(ItslearningClient $client): CourseElementPage
    {
        $data = $this->map($this->courseElementPage);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(CourseElementPage $courseElementPage)
    {
        $data = [];
        if ($courseElementPage->getCourseId() !== null) {
            $data['CourseId'] = $courseElementPage->getCourseId();
        }
        if ($courseElementPage->getCourseSyncKey() !== null) {
            $data['CourseSyncKey'] = $courseElementPage->getCourseSyncKey();
        }
        if ($courseElementPage->getParentSyncKey() !== null) {
            $data['ParentSyncKey'] = $courseElementPage->getParentSyncKey();
        }
        if ($courseElementPage->getUserId() !== null) {
            $data['UserId'] = $courseElementPage->getUserId();
        }
        if ($courseElementPage->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $courseElementPage->getUserSyncKey();
        }
        $data['Title'] = $courseElementPage->getTitle();
        $data['Content'] = $this->mapContent($courseElementPage->getContent());

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($courseElementPage->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $courseElementPage->getSyncKey()
            ];
        }
        $message['CreateCourseElementPage'] = [$data];

        return [
            'Message' => $message
        ];
    }

    private function mapContent(PageContent $content)
    {
        $contentBlockSets = [];
        foreach ($content->getContentBlockSets() as $contentBlockSet) {
            $contentBlockSets[] = $this->mapContentBlockSet($contentBlockSet);
        }
        return [
            'PageContent' => [
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xmlns:xsd' => 'http://www.w3.org/2001/XMLSchema',
                'ContentBlockSets' => $contentBlockSets
            ]
        ];
    }

    private function mapContentBlockSet(ContentBlockSet $contentBlockSet)
    {
        if ($contentBlockSet->getContentBlock() instanceof TextContentBlock) {
            return $this->mapTextContentBlockSet($contentBlockSet);
        }

        throw new ItslearningException('Unknown Content Block type: ' . get_class($contentBlockSet));
    }

    private function mapTextContentBlockSet(ContentBlockSet $textContentBlockSet)
    {
        /** @var TextContentBlock $textContentBlock */
        $textContentBlock = $textContentBlockSet->getContentBlock();

        $mapped = [
            'ContentBlockText' => [
                'Title' => $textContentBlock->getTitle(),
                'Text' => $textContentBlock->getText()
            ]
        ];

        if (count($textContentBlockSet->getFileContents()) > 0) {
            $fileContents = [];
            foreach ($textContentBlockSet->getFileContents() as $fileContent) {
                $fileContents[] = $this->mapFileContent($fileContent);
            }

            $mapped['FileContents'] = [
                'FileContent' => $fileContents
            ];
        }

        return [
            'ContentBlockSet' => $mapped
        ];
    }

    private function mapFileContent(FileContent $fileContent)
    {
        return [
                'FileId' => $fileContent->getFileId(),
                'Location' => $fileContent->getLocation(),
                'Name' => $fileContent->getName(),
                'ContentType' => $fileContent->getContentType()
        ];
    }

    private function transform($result): CourseElementPage
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->courseElementPage->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->courseElementPage;
    }

}