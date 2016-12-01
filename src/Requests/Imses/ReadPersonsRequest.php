<?php


namespace Itslearning\Requests\Imses;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Imses\Person;
use Itslearning\Objects\Imses\PersonName;
use Itslearning\Requests\Imses\Transformers\PersonTransformer;
use Itslearning\Requests\Request;

class ReadPersonsRequest implements Request
{
    const METHOD = 'readPersons';
    /**
     * @var array
     */
    private $syncIDs;

    /**
     * ReadPersonsRequest constructor.
     * @param array $syncIDs
     */
    public function __construct(array $syncIDs)
    {
        $this->syncIDs = $syncIDs;
    }

    /**
     * @param ItslearningClient $client
     * @return Person[]
     */
    public function execute(ItslearningClient $client): array
    {
        $arguments = $this->map();

        $result = $client->call(self::METHOD, $arguments);

        return $this->transform($result);
    }

    private function map()
    {
        return [
            'readPersonsRequest' => [
                'sourcedIdSet' => [
                    'identifier' => $this->syncIDs
                ]
            ]
        ];
    }

    private function transform($result)
    {
        if (!isset($result->personSet->person)) {
            throw new RequestException('No personSet in readPersons response');
        }

        $persons = [];
        foreach ($result->personSet->person as $item) {
            $persons[]= PersonTransformer::fromResponse($item);
        }

        return $persons;
    }
}