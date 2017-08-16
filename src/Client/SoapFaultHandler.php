<?php


namespace Itslearning\Client;


/**
 * SoapFaultHandler to be able to have a custom error handler
 * @package Itslearning\Client
 */
interface SoapFaultHandler
{

    /**
     * @param \SoapFault $soapFault
     * @param \SoapClient $soapClient
     * @return mixed
     */
    public function handleSoapFault(\SoapFault $soapFault, \SoapClient $soapClient);
}