<?php


namespace Itslearning\Client\Interceptors;

use Itslearning\Exceptions\AuthenticationException;
use Itslearning\ItslearningCredentials;
use SoapClient;

class OrganisationAuthenticationInterceptor extends AuthenticationInterceptor
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
        $username = $this->credentials->getOrganisationLogin();
        $password = $this->credentials->getOrganisationPassword();

        if (empty($username) || empty($password)) {
            throw new AuthenticationException('No Organisation Api credentials set');
        }

        $header = $this->toHeader($username, $password);
        $client->__setSoapHeaders([$header]);

        return $client;
    }

}