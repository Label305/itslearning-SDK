<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\ItslearningException;
use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Objects\Organisation\ExtensionInstanceContent;
use Itslearning\Objects\Organisation\ExtensionInstanceLTIContent;
use Itslearning\Requests\Request;

class CreateExtensionInstanceRequest implements Request
{
    const MESSAGE_TYPE_NAME = 'Create.Extension.Instance';
    /**
     * @var ExtensionInstance
     */
    private $extensionInstance;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * CreateExtensionInstanceRequest constructor.
     * @param ExtensionInstance $extensionInstance
     * @param int $messageTypeIdentifier
     */
    public function __construct(ExtensionInstance $extensionInstance, int $messageTypeIdentifier)
    {
        $this->extensionInstance = $extensionInstance;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return ExtensionInstance
     */
    public function execute(ItslearningClient $client): ExtensionInstance
    {
        $data = $this->map($this->extensionInstance);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    /**
     * @return array
     */
    protected function map(ExtensionInstance $extensionInstance): array
    {
        $data = [];

        if ($extensionInstance->getSiteId() !== null) {
            $data['SiteId'] = $extensionInstance->getSiteId();
        }
        if ($extensionInstance->getVendorId() !== null) {
            $data['VendorId'] = $extensionInstance->getVendorId();
        }
        $data['Location'] = $extensionInstance->getLocation();
        $data['ExtensionId'] = $extensionInstance->getExtensionId();
        if ($extensionInstance->getCourseId() !== null) {
            $data['CourseId'] = $extensionInstance->getCourseId();
        }
        if ($extensionInstance->getCourseSyncKey() !== null) {
            $data['CourseSyncKey'] = $extensionInstance->getCourseSyncKey();
        }
        if ($extensionInstance->getParentSyncKey() !== null) {
            $data['ParentSyncKey'] = $extensionInstance->getParentSyncKey();
        }
        if ($extensionInstance->getUserId() !== null) {
            $data['UserId'] = $extensionInstance->getUserId();
        }
        if ($extensionInstance->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $extensionInstance->getUserSyncKey();
        }
        $data['Title'] = $extensionInstance->getTitle();
        $data['Content'] = $this->mapContent($extensionInstance->getContent());
        if ($extensionInstance->getDisallowModification() !== null) {
            $data['DisallowModification'] = $extensionInstance->getDisallowModification();
        }

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];
        if ($extensionInstance->getSyncKey() !== null) {
            $message['SyncKeys'] = [
                'SyncKey' => $extensionInstance->getSyncKey()
            ];
        }
        $message['CreateExtensionInstance'] = [$data];

        return [
            'Message' => $message
        ];
    }

    /**
     * @param $result
     * @return ExtensionInstance
     */
    protected function transform($result): ExtensionInstance
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->extensionInstance->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->extensionInstance;
    }

    private function mapContent(ExtensionInstanceContent $extensionInstanceContent)
    {
        if ($extensionInstanceContent instanceof ExtensionInstanceLTIContent) {
            return $this->mapLTIContent($extensionInstanceContent);
        }

        throw new ItslearningException('Unknown extension instance content object received: ' . get_class($extensionInstanceContent));
    }

    private function mapLTIContent(ExtensionInstanceLTIContent $extensionInstanceContent)
    {
        $content = [];

        if ($extensionInstanceContent->getXmlConfigurationUrl() !== null) {
            $content['XmlConfiguration'] = [
                'Url' => $extensionInstanceContent->getXmlConfigurationUrl()
            ];
        }
        if ($extensionInstanceContent->getXmlConfigurationXml() !== null) {
            $content['XmlConfiguration'] = [
                'Xml' => '<![XML[' . $extensionInstanceContent->getXmlConfigurationXml() . ']]>'
            ];
        }

        return [
            'LtiContent' => $content
        ];
    }
}