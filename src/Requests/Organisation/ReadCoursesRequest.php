<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\PaginatedResponse;
use Itslearning\Requests\Request;

class ReadCoursesRequest implements Request
{
    const METHOD = 'ReadCourses';
    const NAMESPACE_SERVICE_ENTITIES = 'http://schemas.datacontract.org/2004/07/Itslearning.Integration.ContentImport.Model.ServiceEntities';
    const NAMESPACE_TEMPURI = 'http://tempuri.org/';
    /**
     * @var int
     */
    private $pageIndex;
    /**
     * @var int
     */
    private $pageSize;

    /**
     * ReadCoursesRequest constructor.
     * @param int $pageIndex
     * @param int $pageSize
     */
    public function __construct(int $pageIndex, int $pageSize)
    {
        $this->pageIndex = $pageIndex;
        $this->pageSize = $pageSize;
    }

    /**
     * @param ItslearningClient $client
     * @return PaginatedResponse
     */
    public function execute(ItslearningClient $client)
    {
        $arguments = $this->getArguments();

        $result = $client->call(self::METHOD, $arguments);

        $courses = $this->transform($result);

        if (!isset($result->ReadCoursesResult->CurrentPageIndex)) {
            throw new RequestException('No CurrentPageIndex in Read.Courses response');
        }
        if (!isset($result->ReadCoursesResult->Total)) {
            throw new RequestException('No Total in Read.Courses response');
        }

        return new PaginatedResponse(
            $result->ReadCoursesResult->CurrentPageIndex,
            $result->ReadCoursesResult->Total,
            $courses
        );
    }

    /**
     * @return array
     */
    protected function getArguments(): array
    {
        $pageIndex = new \SoapVar($this->pageIndex, XSD_INT, null, null, 'PageIndex', self::NAMESPACE_SERVICE_ENTITIES);
        $pageSize = new \SoapVar($this->pageSize, XSD_INT, null, null, 'PageSize', self::NAMESPACE_SERVICE_ENTITIES);

        $arguments = [
            new \SoapVar(
                [
                    'request' => new \SoapVar(
                        [$pageIndex, $pageSize],
                        SOAP_ENC_OBJECT,
                        null,
                        null,
                        'request',
                        self::NAMESPACE_TEMPURI
                    )
                ],
                SOAP_ENC_OBJECT
            )
        ];

        return $arguments;
    }

    private function transform($result)
    {
        if(!isset($result->ReadCoursesResult->Courses->Course)) {
            throw new RequestException('No Coureses in Read.Courses response');
        }
       
        $courses = [];
        foreach ($result->ReadCoursesResult->Courses->Course as $rawCourse) {
            $course = new Course();
            $course->setId($rawCourse->CourseId);
            $course->setSyncKey($rawCourse->CourseSyncKey);
            $course->setTitle($rawCourse->CourseTitle);
            
            $courses[] = $courses;
        }
        
        return $courses;
    }
}