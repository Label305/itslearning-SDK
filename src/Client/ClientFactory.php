<?php


namespace Itslearning\Client;


use Itslearning\ItslearningCredentials;

interface ClientFactory
{

    public function imses(ItslearningCredentials $credentials):ItslearningClient;

    public function organisationData(ItslearningCredentials $credentials):ItslearningClient;
    
    public function organisationReadData(ItslearningCredentials $credentials):ItslearningClient;

}