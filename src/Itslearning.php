<?php

namespace Itslearning;

use Itslearning\Client\ClientFactory;
use Itslearning\Client\SoapClientFactory;
use Itslearning\Exceptions\MessageTypeNotFoundException;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\Extension;
use Itslearning\Objects\Organisation\MessageType;
use Itslearning\Requests\Imses\CreateGroupRequest;
use Itslearning\Requests\Organisation\CreateExtensionInstanceRequest;
use Itslearning\Requests\Organisation\GetMessageTypesRequest;
use Itslearning\Requests\Organisation\UpdateExtensionInstanceRequest;

class Itslearning
{
    /**
     * @var ItslearningCredentials
     */
    private $credentials;

    /**
     * @var MessageType[]|null
     */
    private $messageTypes;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * Itslearning constructor.
     * @param ItslearningCredentials $credentials
     * @param ClientFactory          $clientFactory
     */
    public function __construct(
        ItslearningCredentials $credentials,
        ClientFactory $clientFactory = null
    ) {
        $this->credentials = $credentials;
        $this->clientFactory = $clientFactory === null ? new SoapClientFactory() : $clientFactory;
    }

    /**
     * @param string $id
     * @return int
     * @throws MessageTypeNotFoundException
     */
    public function findMessageTypeIdentifierByName(string $name):int
    {
        if (empty($this->messageTypes)) {
            $this->messageTypes = $this->getMessageTypes();
        }

        foreach ($this->messageTypes as $type) {
            if ($type->getName() === $name) {
                return $type->getIdentifier();
            }
        }

        throw new MessageTypeNotFoundException('Message type "' . $name . '" not found');
    }

    /**
     * @return MessageType[]
     */
    public function getMessageTypes():array
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $request = new GetMessageTypesRequest();

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/createGroup.html
     * @param Course $course
     * @return Course
     */
    public function createCourse(Course $course):Course
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new CreateGroupRequest($course);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Extension.Instance.html
     * @param Extension $extension
     * @return Extension
     */
    public function createExtension(Extension $extension):Extension
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new CreateExtensionInstanceRequest($extension, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Update.Extension.Instance.html
     * @param Extension $extension
     * @return Extension
     */
    public function updateExtension(Extension $extension):Extension
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(UpdateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new UpdateExtensionInstanceRequest($extension, $messageTypeIdentifier);

        return $request->execute($client);
    }

}
