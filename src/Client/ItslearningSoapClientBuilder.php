<?php


namespace Itslearning\Client;


use Itslearning\Client\Interceptors\Interceptor;

class ItslearningSoapClientBuilder
{

    /**
     * @var Interceptor[]
     */
    private $interceptors = [];

    /**
     * @var ServiceProvider
     */
    private $serviceProvider;

    /**
     * ItslearningSoapClientBuilder constructor.
     * @param string|null $env
     */
    public function __construct(string $env = null)
    {
        $this->serviceProvider = new ServiceProvider($env);
    }

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
        return $this->build($this->serviceProvider->getImsesWsdlUrl());
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisationData(): ItslearningSoapClient
    {
        return $this->build($this->serviceProvider->getOrganisationDataWsdlUrl());
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisationReadData(): ItslearningSoapClient
    {
        return $this->build($this->serviceProvider->getOrganisationReadDataWsdlUrl());
    }

    /**
     * @return ItslearningSoapClient
     */
    public function organisationFile(): ItslearningSoapClient
    {
        return $this->build($this->serviceProvider->getOrganisationFileWsdlUrl());
    }

    /**
     * @param string $wsdl
     * @return ItslearningSoapClient
     */
    private function build(string $wsdl): ItslearningSoapClient
    {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => !$this->serviceProvider->isTesting(),
                'verify_peer_name' => !$this->serviceProvider->isTesting(),
                'allow_self_signed' => $this->serviceProvider->isTesting()
            ]
        ]);

        $soapClient = new \SoapClient($wsdl, [
            'stream_context' => $context,
            'cache_wsdl' => WSDL_CACHE_MEMORY,
            'trace' => true,
            'keep_alive' => false
        ]);

        foreach ($this->interceptors as $interceptor) {
            $soapClient = $interceptor->handle($soapClient);
        }

        $client = new ItslearningSoapClient($soapClient);

        return $client;
    }
}