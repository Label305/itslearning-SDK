<?php


namespace Itslearning\Interceptors;


use Itslearning\Exceptions\AuthenticationException;
use Itslearning\ItslearningCredentials;
use Itslearning\ItslearningSoapClient;

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
     * @param ItslearningSoapClient $client
     * @return ItslearningSoapClient
     */
    public function handle(ItslearningSoapClient $client):ItslearningSoapClient
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