<?php


namespace Itslearning\Objects\Organisation;


class ExtensionInstanceLTIContent implements ExtensionInstanceContent
{

    /**
     * @var string|null
     */
    private $xmlConfigurationUrl;

    /**
     * @var string|null
     */
    private $xmlConfigurationXml;

    /**
     * @return null|string
     */
    public function getXmlConfigurationUrl()
    {
        return $this->xmlConfigurationUrl;
    }

    /**
     * @param null|string $xmlConfigurationUrl
     */
    public function setXmlConfigurationUrl($xmlConfigurationUrl)
    {
        $this->xmlConfigurationUrl = $xmlConfigurationUrl;
    }

    /**
     * @return null|string
     */
    public function getXmlConfigurationXml()
    {
        return $this->xmlConfigurationXml;
    }

    /**
     * @param null|string $xmlConfigurationXml
     */
    public function setXmlConfigurationXml($xmlConfigurationXml)
    {
        $this->xmlConfigurationXml = $xmlConfigurationXml;
    }
  
}