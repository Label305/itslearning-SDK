<?php


namespace tests\Client;


use Itslearning\Client\ItslearningSoapClient;
use Mockery\MockInterface;
use Tests\TestCase;

class ItslearningSoapClientTest extends TestCase
{

    public function testCall()
    {
        /* Given */
        /** @var \SoapClient $soapClient */
        $soapClient = \Mockery::mock(\SoapClient::class);
        $itslearningSoapClient = new ItslearningSoapClient($soapClient);

        $method = 'DoSomething';
        $arguments = [
            [
                'sourcedId' => [
                    'identifier' => 'MySourceId'
                ]
            ]
        ];

        /* Then */
        $soapClient->shouldReceive('__soapCall')->with($method, $arguments, null, null, null);

        /* When */
        $itslearningSoapClient->call($method, $arguments);
    }

    public function testMessage()
    {
        /* Given */
        /** @var \SoapClient|MockInterface $soapClient */
        $soapClient = \Mockery::mock(\SoapClient::class);
        $itslearningSoapClient = new ItslearningSoapClient($soapClient);

        $type = 'Create.Extension.Instance';
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => 'MySyncKey'
                ]
            ]
        ];

        /* Then */
        $message = [
            [
                'dataMessage' => [
                    "Data" => '<?xml version="1.0" encoding="UTF-8"?>
<Message xmlns="urn:message-schema"><SyncKeys><SyncKey>MySyncKey</SyncKey></SyncKeys></Message>
',
                    'Type' => 'Create.Extension.Instance'
                ]
            ]
        ];
        $soapClient->shouldReceive('__soapCall')->times(1)->with('AddMessage', $message, null, null,
            null)->andReturn((object)[
            'AddMessageResult' => (object)[
                'MessageId' => 1337
            ]
        ]);

        $messageResultArgument = [
            [
                'messageId' => 1337
            ]
        ];
        $soapClient->shouldReceive('__soapCall')->times(1)
            ->with('GetMessageResult', $messageResultArgument, null, null, null)
            ->andReturn((object)[
                'GetMessageResultResult' => (object)[
                    'Status' => ItslearningSoapClient::STATUS_FINISHED,
                    'StatusDetails' => (object)[
                        'DataMessageStatusDetail' => (object)[
                            'Type' => ItslearningSoapClient::MESSAGE_STATUS_TYPE_INFO
                        ]
                    ]
                ]
            ]);

        /* When */
        $itslearningSoapClient->message($type, $data);
    }

    public function testMessageBackOff()
    {
        /* Given */
        /** @var \SoapClient|MockInterface $soapClient */
        $soapClient = \Mockery::mock(\SoapClient::class);
        $itslearningSoapClient = new ItslearningSoapClient($soapClient);

        $type = 'Create.Extension.Instance';
        $data = [
            'Message' => [
                'xmlns:' => 'urn:message-schema',
                'SyncKeys' => [
                    'SyncKey' => 'MySyncKey'
                ]
            ]
        ];

        /* Then */
        $message = [
            [
                'dataMessage' => [
                    "Data" => '<?xml version="1.0" encoding="UTF-8"?>
<Message xmlns="urn:message-schema"><SyncKeys><SyncKey>MySyncKey</SyncKey></SyncKeys></Message>
',
                    'Type' => 'Create.Extension.Instance'
                ]
            ]
        ];
        $soapClient->shouldReceive('__soapCall')->times(1)
            ->with('AddMessage', $message, null, null, null)
            ->andReturn((object)[
                'AddMessageResult' => (object)[
                    'MessageId' => 1337
                ]
            ]);

        $messageResultArgument = [
            [
                'messageId' => 1337
            ]
        ];
        $soapClient->shouldReceive('__soapCall')->times(1)
            ->with('GetMessageResult', $messageResultArgument, null, null, null)
            ->andReturn((object)[
                'GetMessageResultResult' => (object)[
                    'Status' => ItslearningSoapClient::STATUS_INQUEUE,
                    'StatusDetails' => (object)[
                        'DataMessageStatusDetail' => (object)[
                            'Type' => ItslearningSoapClient::MESSAGE_STATUS_TYPE_INFO
                        ]
                    ]
                ]
            ]);

        $messageResultArgument = [
            [
                'messageId' => 1337
            ]
        ];
        $soapClient->shouldReceive('__soapCall')->times(1)
            ->with('GetMessageResult', $messageResultArgument, null, null, null)
            ->andReturn((object)[
                'GetMessageResultResult' => (object)[
                    'Status' => ItslearningSoapClient::STATUS_FINISHED,
                    'StatusDetails' => (object)[
                        'DataMessageStatusDetail' => (object)[
                            'Type' => ItslearningSoapClient::MESSAGE_STATUS_TYPE_INFO
                        ]
                    ]
                ]
            ]);

        /* When */
        $itslearningSoapClient->message($type, $data);
    }

}

