<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\ExtensionInstance;
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
     * @param int               $messageTypeIdentifier
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
    public function execute(ItslearningClient $client):ExtensionInstance
    {
        $data = $this->map($this->extensionInstance);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    /**
     * @return array
     */
    protected function map(ExtensionInstance $extensionInstance):array
    {
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => $extensionInstance->getSyncKey()
                ],
                'CreateExtensionInstance' => [
                    'Location' => $extensionInstance->getLocation(),
                    'ExtensionId' => $extensionInstance->getExtensionId(),
                    'CourseSyncKey' => $extensionInstance->getCourseSyncKey(),
                    'UserSyncKey' => $extensionInstance->getUserSyncKey(),
                    'Title' => $extensionInstance->getTitle(),
                    'Metadata' => [
                        'Description' => $extensionInstance->getDescription(),
                        'Language' => $extensionInstance->getLanguage(),
                        'Keywords' => [
                            'Keyword' => $extensionInstance->getKeywords()
                        ],
                        'IntendedEndUserRole' => $extensionInstance->getIntendedEndUserRole(),
                    ],
                    'Content' => [
                        'FileLinkContent' => [
                            'Description' => $extensionInstance->getTitle(),
                            'HideLink' => false,
                            'Link' => $extensionInstance->getContent()
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    }

    /**
     * @param $result
     * @return ExtensionInstance
     */
    protected function transform($result):ExtensionInstance
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->extensionInstance->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->extensionInstance;
    }
}