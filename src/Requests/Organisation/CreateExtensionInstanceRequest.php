<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\Extension;
use Itslearning\Requests\Request;

class CreateExtensionInstanceRequest implements Request
{
    const MESSAGE_TYPE_NAME = 'Create.Extension.Instance';
    /**
     * @var Extension
     */
    private $extension;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * CreateExtensionInstanceRequest constructor.
     * @param Extension $extension
     * @param int       $messageTypeIdentifier
     */
    public function __construct(Extension $extension, int $messageTypeIdentifier)
    {
        $this->extension = $extension;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }


    /**
     * @param ItslearningClient $client
     * @return Extension
     */
    public function execute(ItslearningClient $client):Extension
    {
        $data = $this->map();

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    /**
     * @return array
     */
    protected function map():array
    {
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => $this->extension->getSyncKey()
                ],
                'CreateExtensionInstance' => [
                    'Location' => $this->extension->getLocation(),
                    'ExtensionId' => $this->extension->getExtensionId(),
                    'CourseSyncKey' => $this->extension->getCourseSyncKey(),
                    'UserSyncKey' => $this->extension->getUserSyncKey(),
                    'Title' => $this->extension->getTitle(),
                    'Metadata' => [
                        'Description' => $this->extension->getDescription(),
                        'Language' => $this->extension->getLanguage(),
                        'Keywords' => [
                            'Keyword' => $this->extension->getKeywords()
                        ],
                        'IntendedEndUserRole' => $this->extension->getIntendedEndUserRole(),
                    ],
                    'Content' => [
                        'FileLinkContent' => [
                            'Description' => $this->extension->getTitle(),
                            'HideLink' => false,
                            'Link' => $this->extension->getContent()
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    }

    /**
     * @param $result
     * @return Extension
     */
    protected function transform($result):Extension
    {
        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $this->extension->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $this->extension;
    }
}