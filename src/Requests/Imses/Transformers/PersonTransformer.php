<?php


namespace Itslearning\Requests\Imses\Transformers;


use Itslearning\Objects\Imses\Person;
use Itslearning\Objects\Imses\PersonName;

class PersonTransformer
{
    const NAME_FIRST = 'First';
    const NAME_LAST = 'Last';
    const NAME_NICK = 'Nick';

    /**
     * @param $response
     * @return Person
     */
    public static function fromResponse($response): Person
    {
        $person = new Person();

        $person->setName(self::getName($response));
        $person->setEmail($response->email);

        return $person;
    }

    /**
     * @param $response
     * @return PersonName
     */
    protected static function getName($response): PersonName
    {
        $personName = new PersonName();
        foreach ($response->name->partName as $partName) {
            if ($partName->namePartType === self::NAME_FIRST) {
                $personName->setFirst($partName->namePartValue);
            }
            if ($partName->namePartType === self::NAME_LAST) {
                $personName->setLast($partName->namePartValue);
            }
            if ($partName->namePartType === self::NAME_NICK) {
                $personName->setNick($partName->namePartValue);
            }
        }

        return $personName;
    }
}