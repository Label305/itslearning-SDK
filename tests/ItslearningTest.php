<?php


namespace Tests;


use Itslearning\Objects\Imses\Course;
use Itslearning\Objects\Organisation\Extension;

class ItslearningTest extends TestCase
{

    public function testGetMessageTypeIdentifier()
    {
        $this->skipInCi();

        /* Given */
        $itslearning = $this->getInstance();

        /* When */
        $result = $itslearning->getMessageTypeIdentifier('Update.Extension.Instance');

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
        /* Given */
        $itslearning = $this->getInstance();

        $extension = new Extension();
        $extension->setSyncKey('SDKTEST' . time());
        $extension->setLocation('Library');
        $extension->setExtensionId(5000);//Should be 5010
        $extension->setCourseSyncKey($this->getCourseSyncKey());
        $extension->setUserSyncKey($this->getUserSyncKey());
        $extension->setTitle('Sdk - TEST');
        $extension->setContent('http://www.label305.com');

        /* When */
        $itslearning->createExtension($extension);
        /* Then */
        //plz no crash
    }
}