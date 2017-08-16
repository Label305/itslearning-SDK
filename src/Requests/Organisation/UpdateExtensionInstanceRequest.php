<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\ItslearningException;
use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Objects\Organisation\ExtensionInstanceContent;
use Itslearning\Objects\Organisation\ExtensionInstanceLTIContent;
use Itslearning\Requests\Request;

class UpdateExtensionInstanceRequest implements Request
{
    const MESSAGE_TYPE_NAME = 'Update.Extension.Instance';
    /**
     * @var ExtensionInstance
     */
    private $extensionInstance;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * UpdateExtensionInstanceRequest constructor.
     * @param ExtensionInstance $extensionInstance
     * @param int               $messageTypeIdentifier
     */
    public function __construct(ExtensionInstance $extensionInstance, int $messageTypeIdentifier)
    {
        $this->extensionInstance = $extensionInstance;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return mixed
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->extensionInstance);

        return $client->message($this->messageTypeIdentifier, $data);
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
        if ($extensionInstance->getSyncKey() !== null) {
            $data['ContentSyncKey'] = $extensionInstance->getSyncKey();
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

        return [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'UpdateExtensionInstance' => [
                    $data
                ]
            ]
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