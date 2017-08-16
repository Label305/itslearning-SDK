<?php


namespace Itslearning\Client;

use Itslearning\Client\Interceptors\ImsesAuthenticationInterceptor;
use Itslearning\Client\Interceptors\OrganisationAuthenticationInterceptor;
use Itslearning\ItslearningCredentials;

class SoapClientFactory implements ClientFactory
{
    /**
     * @var string
     */
    private $env;

    /**
     * SoapClientFactory constructor.
     * @param string $env
     */
    public function __construct(string $env = null)
    {
        $this->env = $env;
    }

    /**
     * @param ItslearningCredentials $credentials
     * @return ItslearningClient
     */
    public function imses(ItslearningCredentials $credentials): ItslearningClient
    {
        return (new ItslearningSoapClientBuilder($this->env))
            ->addInterceptor(new ImsesAuthenticationInterceptor($credentials))
            ->imses();
    }

    /**
     * @param ItslearningCredentials $credentials
     * @return ItslearningClient
     */
    public function organisationData(ItslearningCredentials $credentials): ItslearningClient
    {
        return (new ItslearningSoapClientBuilder($this->env))
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisationData();
    }

    /**
     * @param ItslearningCredentials $credentials
     * @return ItslearningClient
     */
    public function organisationReadData(ItslearningCredentials $credentials): ItslearningClient
    {
        return (new ItslearningSoapClientBuilder($this->env))
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisationReadData();
    }

    /**
     * @param ItslearningCredentials $credentials
     * @return ItslearningClient
     */
    public function organisationFile(ItslearningCredentials $credentials): ItslearningClient
    {
        return (new ItslearningSoapClientBuilder($this->env))
            ->addInterceptor(new OrganisationAuthenticationInterceptor($credentials))
            ->organisationFile();
    }
}