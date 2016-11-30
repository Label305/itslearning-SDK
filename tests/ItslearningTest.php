<?php


namespace Tests;


use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\ExtensionInstance;

class ItslearningTest extends TestCase
{

    public function testGetMessageTypeIdentifier()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $result = $itslearning->findMessageTypeIdentifierByName('Update.Extension.Instance');

        /* Then */
        $this->assertEquals(54, $result);
    }

    public function testCreateCourse()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $course = new Course();
        $course->setName(date('Y-m-d H:i:s') . ' - SDKTest test');
        $course->setShortDescription('SDKTest course');
        $course->setParentSyncKey($this->getHierarchySyncKey());
        $course->setSyncKey('SDKTEST' . date('YmdHis'));
        $course->setUserSyncKey($this->getUserSyncKey());

        /* When */
        $itslearning->createCourse($course);

        /* Then */
        //plz no crash
    }

    public function testCreateExtension()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        $extensionInstance = new ExtensionInstance();
        $extensionInstance->setSyncKey('SDKTEST' . time());
        $extensionInstance->setLocation('Library');
        $extensionInstance->setExtensionId(5000);//Should be 5010
        $extensionInstance->setCourseSyncKey($this->getCourseSyncKey());
        $extensionInstance->setUserSyncKey($this->getUserSyncKey());
        $extensionInstance->setTitle('Sdk - TEST');
        $extensionInstance->setContent('http://www.label305.com');

        /* When */
        $itslearning->createExtension($extensionInstance);
        /* Then */
        //plz no crash
    }

    public function testReadAllPersons()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $persons = $itslearning->readAllPersons(1, 3);

        /* Then */
        $this->assertCount(3, $persons->getData());
    }
}