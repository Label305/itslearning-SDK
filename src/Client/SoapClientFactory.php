<?php


namespace Itslearning\Client;

use Itslearning\Client\Interceptors\ImsesAuthenticationInterceptor;
use Itslearning\Client\Interceptors\OrganisationAuthenticationInterceptor;
use Itslearning\ItslearningCredentials;

class SoapClientFactory implements ClientFactory
{

    public function imses(ItslearningCredentials $credentials):ItslearningClient
    {
        return (new ItslearningSoapClientBuilder())
            ->addInterceptor(new ImsesAuthenticationInterceptor($credentials))
            ->imses();
    }

    public function organisation(ItslearningCredentials $credentials):ItslearningClient
    {
        return (new ItslearningSoapClientBuilder())
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisation();
    }
}