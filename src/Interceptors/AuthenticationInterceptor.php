<?php

namespace Itslearning\Interceptors;

use Itslearning\Interceptor;
use SoapHeader;
use SoapVar;
use stdClass;

abstract class AuthenticationInterceptor implements Interceptor
{

    const NAMESPACE = 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd';
    const CONTAINER = 'Security';


    /**
     * @param string $username
     * @param string $password
     * @return SoapHeader
     */
    protected function toHeader(string $username, string $password):SoapHeader
    {
        $wsseAuth = new stdClass;
        $wsseAuth->Username = new SoapVar($username, XSD_STRING, null, self::NAMESPACE, null, self::NAMESPACE);
        $wsseAuth->Password = new SoapVar($password, XSD_STRING, null, self::NAMESPACE, null, self::NAMESPACE);

        $usernameToken = new SoapVar($wsseAuth, SOAP_ENC_OBJECT, null, self::NAMESPACE, 'UsernameToken',
            self::NAMESPACE);

        $wsseToken = new stdClass();
        $wsseToken->UsernameToken = $usernameToken;

        $objSoapVarWSSEToken = new SoapVar(
            $wsseToken,
            SOAP_ENC_OBJECT,
            null,
            self::NAMESPACE,
            'UsernameToken',
            self::NAMESPACE
        );

        $header = new SoapVar(
            $objSoapVarWSSEToken,
            SOAP_ENC_OBJECT,
            null,
            self::NAMESPACE,
            self::CONTAINER,
            self::NAMESPACE
        );

        return new SoapHeader(self::NAMESPACE, self::CONTAINER, $header);
    }
}