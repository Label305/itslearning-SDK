<?php


namespace Itslearning\Requests\Imses;


use Itslearning\Client\ItslearningClient;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Imses\Person;
use Itslearning\Objects\Imses\PersonName;
use Itslearning\Requests\Imses\Transformers\PersonTransformer;
use Itslearning\Requests\Request;

class ReadPersonRequest implements Request
{
    const METHOD = 'readPerson';

    /**
     * @var string
     */
    private $syncID;

    /**
     * ReadPersonRequest constructor.
     * @param string $syncID
     */
    public function __construct(string $syncID)
    {
        $this->syncID = $syncID;
    }

    /**
     * @param ItslearningClient $client
     * @return Person
     */
    public function execute(ItslearningClient $client): Person
    {
        $arguments = $this->map();

        $result = $client->call(self::METHOD, $arguments);

        return $this->transform($result);
    }

    private function map()
    {
        return [
            'readPersonRequest' => [
                'sourcedId' => [
                    'identifier' => $this->syncID
                ]
            ]
        ];
    }

    private function transform($result)
    {
        if (!isset($result->person)) {
            throw new RequestException('No person in readPerson response');
        }

        return PersonTransformer::fromResponse($result->person);
    }
}