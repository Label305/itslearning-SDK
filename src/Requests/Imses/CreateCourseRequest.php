<?php


namespace Itslearning\Requests\Imses;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Imses\Course;
use Itslearning\Requests\Request;

class CreateCourseRequest implements Request
{
    const METHOD = 'createGroup';

    /**
     * @var Course
     */
    private $course;

    /**
     * CreateCourseRequest constructor.
     * @param Course $course
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * @param ItslearningClient $client
     * @return mixed
     */
    public function execute(ItslearningClient $client)
    {
        $arguments = $this->map();

        $client->call(self::METHOD, $arguments);

        return $this->course;
    }

    /**
     * @return array
     */
    private function map():array
    {
        $arguments = [
            [
                'sourcedId' => [
                    'identifier' => $this->course->getSyncKey()
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
                            'identifier' => $this->course->getParentSyncKey()
                        ]
                    ],
                    'description' => [
                        'descShort' => $this->course->getShortDescription(),
                        'descLong' => $this->course->getShortDescription(),
                        'descFull' => $this->course->getShortDescription()
                    ],
                    'extension' => [
                        'extensionField' => [
                            [
                                'fieldName' => 'course',
                                'fieldType' => 'String',
                                'fieldValue' => $this->course->getName()
                            ],
                            [
                                'fieldName' => 'course/code',
                                'fieldType' => 'String',
                                'fieldValue' => $this->course->getCode()
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $arguments;
    }
}