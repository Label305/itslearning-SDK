<?php


namespace tests\Requests\Imses;


use Itslearning\Objects\Imses\Course;
use Itslearning\Requests\Imses\CreateCourseRequest;
use Tests\Support\SpyItslearningClient;
use Tests\TestCase;

class CreateCourseRequestTest extends TestCase
{

    public function testMap()
    {
        /* Given */
        $course = new Course();
        $course->setTitle('MyName');
        $course->setSyncKey('MySyncKey');
        $course->setParentSyncKey('MyParentSyncKey');
        $course->setUserSyncKey('MyUserSyncKey');
        $course->setShortDescription('MyShortDescription');
        $course->setLongDescription('MyLongDescription');
        $course->setFullDescription('MyFullDescription');
        $course->setCode('MyCode');
        $course->setCredits('MyCredits');

        $createCourseRequest = new CreateCourseRequest($course);
        $client = new SpyItslearningClient();

        /* When */
        $createCourseRequest->execute($client);

        /* Then */
        $this->assertEquals([
            [
                'sourcedId' => [
                    'identifier' => 'MySyncKey'
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
                            'identifier' => 'MyParentSyncKey'
                        ]
                    ],
                    'description' => [
                        'descShort' => 'MyShortDescription',
                        'descLong' => 'MyLongDescription',
                        'descFull' => 'MyFullDescription'
                    ],
                    'extension' => [
                        'extensionField' => [
                            [
                                'fieldName' => 'course',
                                'fieldType' => 'String',
                                'fieldValue' => 'MyName'
                            ],
                            [
                                'fieldName' => 'course/code',
                                'fieldType' => 'String',
                                'fieldValue' => 'MyCode'
                            ]
                        ]
                    ]
                ]
            ]
        ], $client->callArguments);

    }

}