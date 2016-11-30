<?php


namespace Itslearning\Objects\Imses;


class Person
{

    /**
     * @var string
     */
    private $userId;

    /**
     * @var PersonName
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return PersonName
     */
    public function getName(): PersonName
    {
        return $this->name;
    }

    /**
     * @param PersonName $name
     */
    public function setName(PersonName $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

}