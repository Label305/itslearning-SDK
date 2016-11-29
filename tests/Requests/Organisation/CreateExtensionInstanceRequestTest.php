<?php


namespace tests\Requests\Organisation;


use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Requests\Organisation\CreateExtensionInstanceRequest;
use Tests\Support\SpyItslearningClient;
use Tests\TestCase;

class CreateExtensionInstanceRequestTest extends TestCase
{

    public function testMap()
    {
        /* Given */
        $extensionInstance = new ExtensionInstance();
        $extensionInstance->setSyncKey('MySyncKey');
        $extensionInstance->setLocation('MyLocation');
        $extensionInstance->setExtensionId(5000);//Should be 5010
        $extensionInstance->setCourseSyncKey('MyCourseSyncKey');
        $extensionInstance->setUserSyncKey('MyUserSyncKey');
        $extensionInstance->setTitle('MyTitle');
        $extensionInstance->setContent('MyContent');

        $createExtensionInstanceRequest = new CreateExtensionInstanceRequest($extensionInstance, 3);
        $client = new SpyItslearningClient();

        /* When */
        $createExtensionInstanceRequest->execute($client);

        /* Then */
        $this->assertEquals([
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => 'MySyncKey'
                ],
                'CreateExtensionInstance' => [
                    'Location' => 'MyLocation', 
                    'ExtensionId' => 5000,
                    'CourseSyncKey' => 'MyCourseSyncKey',
                    'UserSyncKey' => 'MyUserSyncKey',
                    'Title' => 'MyTitle',
                    'Metadata' => [
                        'Description' => null,
                        'Language' => null,
                        'Keywords' => [
                            'Keyword' => null
                        ],
                        'IntendedEndUserRole' => null,
                    ],
                    'Content' => [
                        'FileLinkContent' => [
                            'Description' => 'MyTitle',
                            'HideLink' => false,
                            'Link' => 'MyContent'
                        ]
                    ]
                ]
            ]
        ], $client->messageData);
    }

}