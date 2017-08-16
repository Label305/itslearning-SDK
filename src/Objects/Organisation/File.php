<?php


namespace Itslearning\Objects\Organisation;


class File
{
    
    /**
     * @var string|null
     */
    private $syncKey;

    /**
     * @var string
     */
    private $fileSyncKey;

    /**
     * @return null|string
     */
    public function getSyncKey()
    {
        return $this->syncKey;
    }

    /**
     * @param null|string $syncKey
     */
    public function setSyncKey($syncKey)
    {
        $this->syncKey = $syncKey;
    }

    /**
     * @return string
     */
    public function getFileSyncKey(): string
    {
        return $this->fileSyncKey;
    }

    /**
     * @param string $fileSyncKey
     */
    public function setFileSyncKey(string $fileSyncKey)
    {
        $this->fileSyncKey = $fileSyncKey;
    }

}