<?php


namespace Itslearning\Client\Interceptors;


use Itslearning\Client\ItslearningSoapClient;

interface Interceptor
{

    /**
     * @param ItslearningSoapClient $client
     * @return ItslearningSoapClient
     */
    public function handle(ItslearningSoapClient $client):ItslearningSoapClient;

}