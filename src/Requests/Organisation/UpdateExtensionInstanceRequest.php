<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\Extension;
use Itslearning\Requests\Request;

class UpdateExtensionInstanceRequest implements Request
{
    const MESSAGE_TYPE_NAME = 'Update.Extension.Instance';
    /**
     * @var Extension
     */
    private $extension;
    /**
     * @var int
     */
    private $messageTypeIdentifier;

    /**
     * UpdateExtensionInstanceRequest constructor.
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
     * @return mixed
     */
    public function execute(ItslearningClient $client)
    {
        $extension = $this->extension;

        $data = $this->map($extension);

        return $client->message($this->messageTypeIdentifier, $data);
    }

    /**
     * @param Extension $extension
     * @return array
     */
    protected function map(Extension $extension):array
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