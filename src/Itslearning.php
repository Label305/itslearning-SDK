<?php

namespace Itslearning;

use Itslearning\Client\ClientFactory;
use Itslearning\Client\SoapClientFactory;
use Itslearning\Exceptions\MessageTypeNotFoundException;
use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\ExtensionInstance;
use Itslearning\Objects\Organisation\MessageType;
use Itslearning\Objects\PaginatedResponse;
use Itslearning\Requests\Imses\CreateCourseRequest;
use Itslearning\Requests\Imses\ReadAllPersonsRequest;
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
     * Create a group of type course
     *
     * @link http://developer.itslearning.com/createGroup.html
     * @param Course $course
     * @return Course
     */
    public function createCourse(Course $course): Course
    {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new CreateCourseRequest($course);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Create.Extension.Instance.html
     * @param ExtensionInstance $extensionInstance
     * @return ExtensionInstance
     */
    public function createExtension(ExtensionInstance $extensionInstance): ExtensionInstance
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(CreateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new CreateExtensionInstanceRequest($extensionInstance, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/Update.Extension.Instance.html
     * @param ExtensionInstance $extensionInstance
     * @return ExtensionInstance
     */
    public function updateExtension(ExtensionInstance $extensionInstance): ExtensionInstance
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $messageTypeIdentifier = $this->findMessageTypeIdentifierByName(UpdateExtensionInstanceRequest::MESSAGE_TYPE_NAME);
        $request = new UpdateExtensionInstanceRequest($extensionInstance, $messageTypeIdentifier);

        return $request->execute($client);
    }

    /**
     * @link http://developer.itslearning.com/DataService.svc_methods_and_messages.html
     * @return MessageType[]
     */
    public function getMessageTypes(): array
    {
        $client = $this->clientFactory->organisation($this->credentials);

        $request = new GetMessageTypesRequest();

        return $request->execute($client);
    }

    /**
     * @param string $id
     * @return int
     * @throws MessageTypeNotFoundException
     */
    public function findMessageTypeIdentifierByName(string $name): int
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
     * http://developer.itslearning.com/readAllPersons.html
     * @param int  $pageIndex
     * @param int  $pageSize
     * @param null $createdFrom
     * @param bool $onlyManuallyCreatedUsers
     * @param bool $convertFromManual
     * @return PaginatedResponse
     */
    public function readAllPersons(
        int $pageIndex = 1,
        int $pageSize = 1,
        $createdFrom = null,
        bool $onlyManuallyCreatedUsers = false,
        bool $convertFromManual = false
    ): PaginatedResponse {
        $client = $this->clientFactory->imses($this->credentials);

        $request = new ReadAllPersonsRequest(
            $pageIndex,
            $pageSize,
            $createdFrom,
            $onlyManuallyCreatedUsers,
            $convertFromManual
        );

        return $request->execute($client);
    }

}
