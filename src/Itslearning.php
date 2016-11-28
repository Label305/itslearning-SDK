<?php

namespace Itslearning;

use Itslearning\Exceptions\MessageTypeNotFoundException;
use Itslearning\Interceptors\ImsesAuthenticationInterceptor;
use Itslearning\Interceptors\OrganisationAuthenticationInterceptor;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\Extension;
use Itslearning\Objects\Organisation\MessageType;

class Itslearning
{
    /**
     * @var ItslearningCredentials
     */
    private $credentials;

    /**
     * @var array
     */
    private $messageTypes;

    /**
     * Itslearning constructor.
     * @param ItslearningCredentials $credentials
     */
    public function __construct(ItslearningCredentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param string $id
     * @return int
     * @throws MessageTypeNotFoundException
     */
    public function getMessageTypeIdentifier(string $name):int
    {
        if (empty($this->messageTypes)) {
            $client = ItslearningSoapClient::builder()
                ->addInterceptor(new OrganisationAuthenticationInterceptor($this->credentials))
                ->organisation();

            $arguments = [];
            $result = $client->__soapCall('GetMessageTypes', $arguments);
            $this->messageTypes = $result->GetMessageTypesResult->DataMessageType;
        }

        foreach ($this->messageTypes as $type) {
            if ($type->Name == $name) {
                return $type->Identifier;
            }
        }

        throw new MessageTypeNotFoundException('Message type "' . $name . '" not found');
    }

    /**
     * @param Course $course
     * @return Course
     */
    public function createCourse(Course $course):Course
    {
        $client = ItslearningSoapClient::builder()
            ->addInterceptor(new ImsesAuthenticationInterceptor($this->credentials))
            ->imses();

        $arguments = [
            [
                'sourcedId' => [
                    'identifier' => $course->getSyncKey()
                ],
                'group' => [
                    'groupType' => [
                        'scheme' => 'ItsLearningOrganisationTypes',
                        'typeValue' => [
                            'type' => 'Course'
                        ]
                    ],
                    'relationship' => [
                        'relation' => 'Parent',
                        'sourceId' => [
                            'identifier' => $course->getParentSyncKey()
                        ]
                    ],
                    'description' => [
                        'descShort' => $course->getShortDescription()
                    ],
                    'extension' => [
                        'extensionField' => [
                            [
                                'fieldName' => 'course',
                                'fieldType' => 'String',
                                'fieldValue' => $course->getName()
                            ],
                            [
                                'fieldName' => 'course/code',
                                'fieldType' => 'String',
                                'fieldValue' => ''
                            ],
                            [
                                'fieldName' => 'course/credits',
                                'fieldType' => 'String',
                                'fieldValue' => ''
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $client->__soapCall('createGroup', $arguments);

        return $course;
    }

    /**
     * http://developer.itslearning.com/Create.Extension.Instance.html
     *
     * @param Extension $extension
     * @return Extension
     */
    public function createExtension(Extension $extension):Extension
    {
        $client = ItslearningSoapClient::builder()
            ->addInterceptor(new OrganisationAuthenticationInterceptor($this->credentials))
            ->organisation();

        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => $extension->getSyncKey()
                ],
                'CreateExtensionInstance' => [
                    'Location' => $extension->getLocation(),
                    'ExtensionId' => $extension->getExtensionId(),
                    'CourseSyncKey' => $extension->getCourseSyncKey(),
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

        $result = $client->addMessage(
            $this->getMessageTypeIdentifier('Create.Extension.Instance'),
            $data
        );

        if (isset($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey)) {
            $extension->setSyncKey($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey);
        }

        return $extension;
    }

    /**
     * @param Extension $extension
     * @return Extension
     */
    public function updateExtension(Extension $extension):Extension
    {
        $client = ItslearningSoapClient::builder()
            ->addInterceptor(new OrganisationAuthenticationInterceptor($this->credentials))
            ->organisation();

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

        $client->addMessage(
            $this->getMessageTypeIdentifier('Update.Extension.Instance'),
            $data
        );

        return $extension;
    }

}
