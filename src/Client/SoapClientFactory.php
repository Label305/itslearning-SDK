<?php


namespace Itslearning\Client;

use Itslearning\Client\Interceptors\ImsesAuthenticationInterceptor;
use Itslearning\Client\Interceptors\OrganisationAuthenticationInterceptor;
use Itslearning\Client\Interceptors\ServiceEntitiesInterceptor;
use Itslearning\Client\Interceptors\TmpUriInterceptor;
use Itslearning\ItslearningCredentials;

class SoapClientFactory implements ClientFactory
{

    public function imses(ItslearningCredentials $credentials):ItslearningClient
    {
        return (new ItslearningSoapClientBuilder())
            ->addInterceptor(new ImsesAuthenticationInterceptor($credentials))
            ->imses();
    }

    public function organisationData(ItslearningCredentials $credentials):ItslearningClient
    {
        return (new ItslearningSoapClientBuilder())
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisationData();
    }
    
    public function organisationReadData(ItslearningCredentials $credentials):ItslearningClient
    {
        return (new ItslearningSoapClientBuilder())
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisationReadData();
    }
}