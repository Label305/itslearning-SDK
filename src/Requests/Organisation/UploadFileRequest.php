<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Client\SoapFaultHandler;
use Itslearning\Exceptions\RequestException;
use Itslearning\Objects\Organisation\UploadFile;
use Itslearning\Requests\Request;

class UploadFileRequest implements Request, SoapFaultHandler
{
    /**
     * @var UploadFile
     */
    private $uploadFile;

    /**
     * UploadFileRequest constructor.
     * @param UploadFile $uploadFile
     */
    public function __construct(UploadFile $uploadFile)
    {
        $this->uploadFile = $uploadFile;
    }

    /**
     * @param ItslearningClient $client
     * @return mixed
     */
    public function execute(ItslearningClient $client)
    {
        $data = $this->map($this->uploadFile);

        $result = $client->call('UploadFile', [$data], $this);

        return $this->transform($result);
    }

    /**
     * Itslearning always returns invalid XML so we use our own error handler which tries to extract
     * the upload file result
     * @param \SoapFault $soapFault
     * @param \SoapClient $soapClient
     * @return mixed
     */
    public function handleSoapFault(\SoapFault $soapFault, \SoapClient $soapClient)
    {
        preg_match_all(
            '/<UploadFileResult>(.*)<\/UploadFileResult>/s',
            $soapClient->__getLastResponse(),
            $matches
        );
        if (!empty($matches[1][0])) {
            return $matches[1][0];
        }

        throw new RequestException($soapFault->getMessage(), $soapFault->getCode(), $soapFault);
    }

    private function map(UploadFile $uploadFile): array
    {
        return [
            'fileMessage' => [
                'Content' => $uploadFile->getContent(),
                'Name' => $uploadFile->getName()
            ]
        ];
    }

    private function transform($result): UploadFile
    {
        $this->uploadFile->setSyncKey($result);

        return $this->uploadFile;
    }

}