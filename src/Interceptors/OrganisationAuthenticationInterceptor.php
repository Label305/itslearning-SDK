<?php


namespace Itslearning\Interceptors;


use Itslearning\Exceptions\AuthenticationException;
use Itslearning\ItslearningCredentials;
use Itslearning\ItslearningSoapClient;

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