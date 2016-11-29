<?php


namespace Tests\Requests\Organisation;


use Itslearning\Requests\Organisation\GetMessageTypesRequest;
use Tests\Support\SpyItslearningClient;
use Tests\TestCase;

class GetMessageTypesRequestTest extends TestCase
{

    public function testExecute()
    {
        /* Given */
        $getMessageTypesRequest = new GetMessageTypesRequest();
        $client = new SpyItslearningClient();
        $client->callResponse = (object)[
            'GetMessageTypesResult' => (object)[
                'DataMessageType' => []
            ]
        ];

        /* When */
        $getMessageTypesRequest->execute($client);

        /* Then */
        $this->assertEquals($client->callMethod, 'GetMessageTypes');
    }

}