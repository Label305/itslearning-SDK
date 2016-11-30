<?php


namespace Itslearning\Client\Interceptors;


use Itslearning\Client\ItslearningSoapClient;
use Itslearning\Exceptions\AuthenticationException;
use Itslearning\ItslearningCredentials;
use SoapClient;

class ImsesAuthenticationInterceptor extends AuthenticationInterceptor
{
    /**
     * @var ItslearningCredentials
     */
    private $credentials;

    /**
     * OrganisationAuthenticationInterceptor constructor.
     * @param ItslearningCredentials $credentials
     */
    public function __construct(ItslearningCredentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @param SoapClient $client
     * @return SoapClient
     */
    public function handle(SoapClient $client):SoapClient
    {
        $username = $this->credentials->getImsesLogin();
        $password = $this->credentials->getImsesPassword();

        if (empty($username) || empty($password)) {
            throw new AuthenticationException('No Imses credentials set');
        }

        $header = $this->toHeader($username, $password);
        $client->__setSoapHeaders([$header]);

        return $client;
    }

}