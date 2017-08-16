<?php


namespace Itslearning\Client;

interface ItslearningClient
{

    public function call(string $method, array $arguments, SoapFaultHandler $soapFaultHandler = null);

    public function message(string $type, array $data);

}