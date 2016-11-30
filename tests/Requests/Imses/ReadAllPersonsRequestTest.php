<?php


namespace Tests\Requests\Imses;


use Itslearning\Objects\Imses\Person;
use Itslearning\Requests\Imses\ReadAllPersonsRequest;
use Tests\Support\SpyItslearningClient;
use Tests\TestCase;

class ReadAllPersonsRequestTest extends TestCase
{

    public function testMap()
    {
        /* Given */
        $readAllPersonsRequest = new ReadAllPersonsRequest(1, 1, null, false, false);
        $client = new SpyItslearningClient();

        $client->callResponse = $this->getCallResponse();

        /* When */
        $result = $readAllPersonsRequest->execute($client);

        /* Then */
        $this->assertCount(3, $result->getData());
    }

    public function testMapName()
    {
        /* Given */
        $readAllPersonsRequest = new ReadAllPersonsRequest(1, 1, null, false, false);
        $client = new SpyItslearningClient();

        $client->callResponse = $this->getCallResponse();

        /* When */
        $result = $readAllPersonsRequest->execute($client);

        /* Then */
        /** @var Person $person */
        $person = $result->getData()[1];
        $name = $person->getName();
        $this->assertEquals('its', $name->getFirst());
        $this->assertEquals('support', $name->getLast());
        $this->assertEquals('', $name->getNick());
    }

    private function getCallResponse()
    {
        $response = '{"personIdPairSet":{"personIdPair":[{"sourcedId":{"identifier":""},"person":{"formatName":null,"name":{"partName":[{"namePartType":"First","namePartValue":"Admin"},{"namePartType":"Last","namePartValue":"Admin"},{"namePartType":"Nick","namePartValue":""}]},"email":"support.nl@itslearning.com","URL":"","userId":{"userIdValue":"admin"},"address":{"extadd":"","locality":"","postcode":"","street":""},"demographics":{"gender":"Male"},"institutionRole":{"institutionRoleType":"Learner","primaryRoleType":true},"tel":[{"telType":"Voice","telValue":""},{"telType":"Mobile","telValue":""}]}},{"sourcedId":{"identifier":""},"person":{"formatName":null,"name":{"partName":[{"namePartType":"First","namePartValue":"its"},{"namePartType":"Last","namePartValue":"support"},{"namePartType":"Nick","namePartValue":""}]},"email":"rutger.tuller@itslearning.com","URL":"","userId":{"userIdValue":"itssupport"},"address":{"extadd":"","locality":"","postcode":"","street":""},"demographics":{"gender":"Male"},"institutionRole":{"institutionRoleType":"Learner","primaryRoleType":true},"tel":[{"telType":"Voice","telValue":""},{"telType":"Mobile","telValue":""}]}},{"sourcedId":{"identifier":"20150109-system-admin-label306"},"person":{"formatName":null,"name":{"partName":[{"namePartType":"First","namePartValue":"Label 305"},{"namePartType":"Last","namePartValue":"Admin"},{"namePartType":"Nick","namePartValue":""}]},"email":"nick.velthorst@label305.com","URL":"","userId":{"userIdValue":"Admin305"},"address":{"extadd":"","locality":"","postcode":"","street":""},"demographics":{"gender":"Male"},"institutionRole":{"institutionRoleType":"Learner","primaryRoleType":true},"tel":[{"telType":"Voice","telValue":""},{"telType":"Mobile","telValue":""}]}}]},"virtualCount":5878}';

        return json_decode($response);
    }

}