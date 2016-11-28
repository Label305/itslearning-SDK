<?php


namespace Itslearning;


interface Interceptor
{

    /**
     * @param ItslearningSoapClient $client
     * @return ItslearningSoapClient
     */
    public function handle(ItslearningSoapClient $client):ItslearningSoapClient;

}