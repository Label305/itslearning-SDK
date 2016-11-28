<?php


namespace Itslearning;


class ItslearningCredentials
{

    /**
     * @var string
     */
    private $organisationLogin;

    /**
     * @var string
     */
    private $organisationPassword;

    /**
     * @var string
     */
    private $imsesLogin;

    /**
     * @var string
     */
    private $imsesPassword;

    /**
     * @return string
     */
    public function getOrganisationLogin():string
    {
        return $this->organisationLogin;
    }

    /**
     * @param string $organisationLogin
     */
    public function setOrganisationLogin(string $organisationLogin)
    {
        $this->organisationLogin = $organisationLogin;
    }

    /**
     * @return string
     */
    public function getOrganisationPassword():string
    {
        return $this->organisationPassword;
    }

    /**
     * @param string $organisationPassword
     */
    public function setOrganisationPassword(string $organisationPassword)
    {
        $this->organisationPassword = $organisationPassword;
    }

    /**
     * @return string
     */
    public function getImsesLogin()
    {
        return $this->imsesLogin;
    }

    /**
     * @param string $imsesLogin
     */
    public function setImsesLogin(string $imsesLogin)
    {
        $this->imsesLogin = $imsesLogin;
    }

    /**
     * @return string
     */
    public function getImsesPassword()
    {
        return $this->imsesPassword;
    }

    /**
     * @param string $imsesPassword
     */
    public function setImsesPassword(string $imsesPassword)
    {
        $this->imsesPassword = $imsesPassword;
    }

}