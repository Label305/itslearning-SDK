<?php


namespace Itslearning\Client\Interceptors;


use SoapClient;

interface Interceptor
{

    /**
     * @param SoapClient $client
     * @return SoapClient
     */
    public function handle(SoapClient $client):SoapClient;

}