<?php


namespace Itslearning\Client;


use Itslearning\Client\Interceptors\Interceptor;

class ItslearningSoapClientBuilder
{

    /**
     * @var Interceptor[]
     */
    private $interceptors = [];

    const ORGANISATION_WSDL = 'https://migra.itslearning.com/ContentImport/DataService.svc?wsdl';
    const IMSES_WSDL = 'https://enterprise.itslearning.com/WCFServiceLibrary/ImsEnterpriseServicesPort.svc?wsdl';

    /**
     * @param Interceptor $interceptor
     */
    public function addInterceptor(Interceptor $interceptor):ItslearningSoapClientBuilder
    {
        $this->interceptors[] = $interceptor;

        return $this;
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisation():ItslearningSoapClient
    {
        return $this->build(self::ORGANISATION_WSDL);
    }

    /**
     * @return ItslearningSoapClient
     */
    public function imses():ItslearningSoapClient
    {
        return $this->build(self::IMSES_WSDL);
    }

    /**
     * @param string $wsdl
     * @return ItslearningSoapClient
     */
    private function build(string $wsdl):ItslearningSoapClient
    {
        $client = new ItslearningSoapClient($wsdl, [
            'cache_wsdl' => WSDL_CACHE_NONE,
            'trace' => true
        ]);

        foreach ($this->interceptors as $interceptor) {
            $client = $interceptor->handle($client);
        }

        return $client;
    }
}