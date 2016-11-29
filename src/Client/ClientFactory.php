<?php


namespace Itslearning\Client;


use Itslearning\ItslearningCredentials;

interface ClientFactory
{

    public function imses(ItslearningCredentials $credentials):ItslearningClient;

    public function organisation(ItslearningCredentials $credentials):ItslearningClient;

}