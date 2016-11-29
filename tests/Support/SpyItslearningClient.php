<?php


namespace Tests\Support;


use Itslearning\Client\ItslearningClient;

class SpyItslearningClient implements ItslearningClient
{

    public $callMethod;
    public $callArguments;
    public $callResponse;
    public $messageType;
    public $messageData;
    public $messageResponse;

    public function call(string $method, array $arguments)
    {
        $this->callMethod = $method;
        $this->callArguments = $arguments;
        
        return $this->callResponse;
    }

    public function message(string $type, array $data)
    {
        $this->messageType = $type;
        $this->messageData = $data;
        
        return $this->messageResponse;
    }
}