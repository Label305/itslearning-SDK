<?php


namespace Itslearning\Client;


use Itslearning\Client\Interceptors\Interceptor;

class ItslearningSoapClientBuilder
{

    /**
     * @var Interceptor[]
     */
    private $interceptors = [];

    const ORGANISATION_DATA_WSDL = 'https://migra.itslearning.com/ContentImport/DataService.svc?wsdl';
    const ORGANISATION_READ_DATA_WSDL = 'https://migra.itslearning.com/ContentImport/ReadDataService.svc?wsdl';
    const IMSES_WSDL = 'https://enterprise.itslearning.com/WCFServiceLibrary/ImsEnterpriseServicesPort.svc?wsdl';

    /**
     * @param Interceptor $interceptor
     */
    public function addInterceptor(Interceptor $interceptor): ItslearningSoapClientBuilder
    {
        $this->interceptors[] = $interceptor;

        return $this;
    }

    /**
     * @return ItslearningSoapClient
     */
    public function imses(): ItslearningSoapClient
    {
        return $this->build(self::IMSES_WSDL);
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisationData(): ItslearningSoapClient
    {
        return $this->build(self::ORGANISATION_DATA_WSDL);
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisationReadData(): ItslearningSoapClient
    {
        return $this->build(self::ORGANISATION_READ_DATA_WSDL);
    }

    /**
     * @param string $wsdl
     * @return ItslearningSoapClient
     */
    private function build(string $wsdl): ItslearningSoapClient
    {
        $soapClient = new \SoapClient($wsdl, [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => true
        ]);

        foreach ($this->interceptors as $interceptor) {
            $soapClient = $interceptor->handle($soapClient);
        }

        $client = new ItslearningSoapClient($soapClient);

        return $client;
    }
}