<?php


namespace Itslearning\Requests\Imses;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\IntegrityException;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Imses\Person;
use Itslearning\Objects\Imses\PersonName;
use Itslearning\Objects\PaginatedResponse;
use Itslearning\Requests\Request;

class ReadAllPersonsRequest implements Request
{
    const METHOD = 'readAllPersons';

    /**
     * @var int
     */
    private $pageIndex;
    /**
     * @var int
     */
    private $pageSize;
    /**
     * @var
     */
    private $createdFrom;
    /**
     * @var bool
     */
    private $onlyManuallyCreatedUsers;
    /**
     * @var bool
     */
    private $convertFromManual;

    /**
     * ReadAllPersonsRequest constructor.
     * @param int  $pageIndex
     * @param int  $pageSize
     * @param      $createdFrom
     * @param bool $onlyManuallyCreatedUsers
     * @param bool $convertFromManual
     */
    public function __construct(
        int $pageIndex,
        int $pageSize,
        $createdFrom,
        bool $onlyManuallyCreatedUsers,
        bool $convertFromManual
    ) {
        $this->pageIndex = $pageIndex;
        $this->pageSize = $pageSize;
        $this->createdFrom = $createdFrom;
        $this->onlyManuallyCreatedUsers = $onlyManuallyCreatedUsers;
        $this->convertFromManual = $convertFromManual;
    }


    /**
     * @param ItslearningClient $client
     * @return PaginatedResponse
     */
    public function execute(ItslearningClient $client): PaginatedResponse
    {
        $this->validate();
        $arguments = $this->map();

        $result = $client->call(self::METHOD, $arguments);

        $persons = $this->transform($result);
        $total = $this->getTotal($result);

        return new PaginatedResponse($this->pageIndex, $total, $persons);
    }

    private function map()
    {
        $request = [
            'PageIndex' => $this->pageIndex,
            'PageSize' => $this->pageSize,
            'OnlyManuallyCreatedUsers' => $this->onlyManuallyCreatedUsers,
            'ConvertFromManual' => $this->convertFromManual,
        ];

        if ($this->createdFrom !== null) {
            $request['CreatedFrom'] = $this->createdFrom;
        }

        return [
            'readAllPersonsRequest' => $request
        ];
    }

    private function validate()
    {
        if ($this->onlyManuallyCreatedUsers === false && $this->convertFromManual === true) {
            throw new IntegrityException('For ConvertFromManual to work OnlyManuallyCreatedUsers must be set to true');
        }
    }

    private function transform($result)
    {
        if (!isset($result->personIdPairSet->personIdPair)) {
            throw new RequestException('No personIdPair in readAllPersons response');
        }

        $persons = [];
        foreach ($result->personIdPairSet->personIdPair as $personIdPair) {
            $person = new Person();

            $personName = new PersonName();
            foreach ($personIdPair->person->name->partName as $partName) {
                if ($partName->namePartType === 'First') {
                    $personName->setFirst($partName->namePartValue);
                }
                if ($partName->namePartType === 'Last') {
                    $personName->setLast($partName->namePartValue);
                }
                if ($partName->namePartType === 'Nick') {
                    $personName->setNick($partName->namePartValue);
                }
            }
            $person->setName($personName);

            $person->setEmail($personIdPair->person->email);

            $persons[] = $person;
        }

        return $persons;
    }

    private function getTotal($result): int
    {
        if (!isset($result->virtualCount)) {
            throw new RequestException('No virtualCount found in paginated request of readAllPersons');
        }

        return $result->virtualCount;
    }
}