<?php


namespace Itslearning\Client\Interceptors;

use Itslearning\Client\ItslearningSoapClient;
use Itslearning\Exceptions\AuthenticationException;
use Itslearning\ItslearningCredentials;

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
     * @param ItslearningSoapClient $client
     * @return ItslearningSoapClient
     */
    public function handle(ItslearningSoapClient $client):ItslearningSoapClient
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