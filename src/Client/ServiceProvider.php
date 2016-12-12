<?php


namespace Itslearning\Client;


use Itslearning\Exceptions\EnvironmentNotFoundException;
use Itslearning\Itslearning;

class ServiceProvider
{
    /**
     * @var string
     */
    private $env;

    const PRODUCTION_ORGANISATION_DATA_WSDL = 'https://migra.itslearning.com/ContentImport/DataService.svc?wsdl';
    const PRODUCTION_ORGANISATION_READ_DATA_WSDL = 'https://migra.itslearning.com/ContentImport/ReadDataService.svc?wsdl';
    const PRODUCTION_IMSES_WSDL = 'https://enterprise.itslearning.com/WCFServiceLibrary/ImsEnterpriseServicesPort.svc?wsdl';

    const TESTING_ORGANISATION_DATA_WSDL = 'https://migra.itsltest.com/DataService.svc?wsdl';
    const TESTING_ORGANISATION_READ_DATA_WSDL = 'https://migra.itsltest.com/ReadDataService.svc?wsdl';
    const TESTING_IMSES_WSDL = 'https://enterprise.itsltest.com/WCFServiceLibrary/ImsEnterpriseServicesPort.svc?wsdl';

    /**
     * ServiceProvider constructor.
     */
    public function __construct(string $env = null)
    {
        $this->env = $env ?? Itslearning::PRODUCTION;
    }

    /**
     * @return string
     * @throws EnvironmentNotFoundException
     */
    public function getImsesWsdlUrl(): string
    {
        switch ($this->env) {
            case Itslearning::PRODUCTION:
                return self::PRODUCTION_IMSES_WSDL;
            case Itslearning::TESTING:
                return self::TESTING_IMSES_WSDL;
        }

        throw new EnvironmentNotFoundException('Trying to access environment:' . $this->env);
    }

    /**
     * @return string
     * @throws EnvironmentNotFoundException
     */
    public function getOrganisationDataWsdlUrl(): string
    {
        switch ($this->env) {
            case Itslearning::PRODUCTION:
                return self::PRODUCTION_ORGANISATION_DATA_WSDL;
            case Itslearning::TESTING:
                return self::TESTING_ORGANISATION_DATA_WSDL;
        }

        throw new EnvironmentNotFoundException('Trying to access environment:' . $this->env);
    }

    /**
     * @return string
     * @throws EnvironmentNotFoundException
     */
    public function getOrganisationReadDataWsdlUrl(): string
    {
        switch ($this->env) {
            case Itslearning::PRODUCTION:
                return self::PRODUCTION_ORGANISATION_READ_DATA_WSDL;
            case Itslearning::TESTING:
                return self::TESTING_ORGANISATION_READ_DATA_WSDL;
        }

        throw new EnvironmentNotFoundException('Trying to access environment:' . $this->env);
    }

    /**
     * @return bool
     * @throws EnvironmentNotFoundException
     */
    public function isTesting(): bool
    {
        switch ($this->env) {
            case Itslearning::PRODUCTION:
                return false;
            case Itslearning::TESTING:
                return true;
        }

        throw new EnvironmentNotFoundException('Trying to access environment:' . $this->env);
    }

}