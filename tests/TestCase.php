<?php


namespace Tests;


use Dotenv\Dotenv;
use Itslearning\Itslearning;
use Itslearning\ItslearningCredentials;

class TestCase extends \PHPUnit_Framework_TestCase
{


    public function setUp()
    {
        parent::setUp();

        $dotenv = new Dotenv(__DIR__);
        $dotenv->load();
    }

    /**
     * @return Itslearning
     */
    public function getInstance()
    {
        $credentials = new ItslearningCredentials();
        $credentials->setOrganisationLogin(getenv('ORGANISATION_LOGIN'));
        $credentials->setOrganisationPassword(getenv('ORGANISATION_PASSWORD'));
        $credentials->setImsesLogin(getenv('IMSES_LOGIN'));
        $credentials->setImsesPassword(getenv('IMSES_PASSWORD'));

        return new Itslearning($credentials);
    }

    /**
     * Skip test when ran in CI
     */
    public function skipInCi()
    {
        if (getenv('CI')) {
            $this->markTestSkipped('Skipped in CI');
        }
    }

    /**
     * @return string
     */
    public function getUserSyncKey():string
    {
        return getenv('USER_SYNC_KEY');
    }

    /**
     * @return string
     */
    public function getHierarchySyncKey():string
    {
        return getenv('HIERARCHY_SYNC_KEY');
    }

    /**
     * @return string
     */
    public function getCourseSyncKey():string {
        return getenv('COURSE_SYNC_KEY');
    }

}