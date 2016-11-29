<?php


namespace Itslearning\Requests;


use Itslearning\Client\ItslearningClient;

interface Request
{

    /**
     * @param ItslearningClient $client
     * @return mixed
     */
    public function execute(ItslearningClient $client);
}