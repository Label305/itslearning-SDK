<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\ExtensionInstance;
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
     * @param ExtensionInstance $extension
     * @return array
     */
    protected function map(ExtensionInstance $extension):array
    {
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'UpdateExtensionInstance' => [
                    'ContentSyncKey' => $extension->getSyncKey(),
                    'UserSyncKey' => $extension->getUserSyncKey(),
                    'Title' => $extension->getTitle(),
                    'Metadata' => [
                        'Description' => $extension->getDescription(),
                        'Language' => $extension->getLanguage(),
                        'Keywords' => [
                            'Keyword' => $extension->getKeywords()
                        ],
                        'IntendedEndUserRole' => $extension->getIntendedEndUserRole(),
                    ],
                    'Content' => [
                        'FileLinkContent' => [
                            'Description' => $extension->getTitle(),
                            'HideLink' => false,
                            'Link' => $extension->getContent()
                        ]
                    ]
                ]
            ]
        ];

        return $data;
    }
}