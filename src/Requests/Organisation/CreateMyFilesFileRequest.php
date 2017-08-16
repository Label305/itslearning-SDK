<?php


namespace Itslearning\Requests\Organisation;


use Itslearning\Client\ItslearningClient;
use Itslearning\Objects\Organisation\MyFilesFile;

class CreateMyFilesFileRequest
{

    const CREATE_MY_FILE_FILE_MESSAGE_TYPE_NAME = 'Create.MyFiles.File';


    /**
     * @var int
     */
    private $messageTypeIdentifier;
    /**
     * @var MyFilesFile
     */
    private $myFilesFile;

    /**
     * CreateOrUpdateAppointmentRequest constructor.
     * @param MyFilesFile $myFilesFile
     * @param int $messageTypeIdentifier
     */
    public function __construct(MyFilesFile $myFilesFile, int $messageTypeIdentifier)
    {
        $this->myFilesFile = $myFilesFile;
        $this->messageTypeIdentifier = $messageTypeIdentifier;
    }

    /**
     * @param ItslearningClient $client
     * @return MyFilesFile
     */
    public function execute(ItslearningClient $client): MyFilesFile
    {
        $data = $this->map($this->myFilesFile);

        $result = $client->message($this->messageTypeIdentifier, $data);

        return $this->transform($result);
    }

    private function map(MyFilesFile $myFilesFile)
    {
        $data = [];
        if ($myFilesFile->getUserId() !== null) {
            $data['UserId'] = $myFilesFile->getUserId();
        }
        if ($myFilesFile->getUserSyncKey() !== null) {
            $data['UserSyncKey'] = $myFilesFile->getUserSyncKey();
        }
        $data['Visibility'] = $myFilesFile->getVisibility();

        $message = [
            'xmlns:' => 'urn:message-schema'
        ];

        $message['CreateMyFilesFile'] = [$data];
        $files = [];
        foreach ($myFilesFile->getFiles() as $file) {
            $files[] = $file->getFileSyncKey();
        }

        $message['Files'] = [
            'File' => $files
        ];

        return [
            'Message' => $message
        ];
    }

    private function transform($result): MyFilesFile
    {
        $keys = [];
        if (is_array($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail)) {
            foreach ($result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail as $dataMessageStatusDetail) {
                $keys[] = $dataMessageStatusDetail->SyncKey;
            }
        } else {
            $keys[] = $result->GetMessageResultResult->StatusDetails->DataMessageStatusDetail->SyncKey;
        }
        
        foreach ($this->myFilesFile->getFiles() as $key => $file) {
            if (isset($keys[$key])) {
                $file->setSyncKey($keys[$key]);
            }
        }
        return $this->myFilesFile;
    }

}