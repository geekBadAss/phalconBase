<?php
/**
 * ExceptionLogTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class ExceptionLogTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $exceptionLogs = ExceptionLog::getAll();
        $this->assertContainsOnly('ExceptionLog', $exceptionLogs);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $exceptionLog = new ExceptionLog(
            array(
                'message'  => 'test message',
                'location' => 'test location',
                'object'   => 'test object',
                'dateTime' => date('Y-m-d H:i:s'),
            )
        );
        $id = $exceptionLog->insert();

        $found = ExceptionLog::find($id);
        $this->assertInstanceOf('ExceptionLog', $found);

        $deleted = $exceptionLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $exceptionLog = new ExceptionLog(
            array(
                'message'  => 'test message',
                'location' => 'test location',
                'object'   => 'test object',
                'dateTime' => date('Y-m-d H:i:s'),
            )
        );
        $id = $exceptionLog->insert();
        $this->assertEquals($id, $exceptionLog->id);

        $found = ExceptionLog::find($id);
        $this->assertInstanceOf('ExceptionLog', $found);

        $deleted = $exceptionLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testUpdate
     *
     * @return null
     */
    public function testUpdate()
    {
        //insert
        $exceptionLog = new ExceptionLog(
            array(
                'message'  => 'test message',
                'location' => 'test location',
                'object'   => 'test object',
                'dateTime' => date('Y-m-d H:i:s'),
            )
        );
        $id = $exceptionLog->insert();

        //change something
        $newMessage = 'test message changed';
        $exceptionLog->message = $newMessage;

        //update
        $updated = $exceptionLog->update();
        $this->assertEquals(1, $updated);

        //find
        $found = ExceptionLog::find($id);
        $this->assertEquals($newMessage, $found->message);

        //clean up
        $deleted = $exceptionLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testDelete
     *
     * @return null
     */
    public function testDelete()
    {
        //insert
        $exceptionLog = new ExceptionLog(
            array(
                'message'  => 'test message',
                'location' => 'test location',
                'object'   => 'test object',
                'dateTime' => date('Y-m-d H:i:s'),
            )
        );
        $id = $exceptionLog->insert();

        //find
        $found = ExceptionLog::find($id);
        $this->assertInstanceOf('ExceptionLog', $found);

        //delete
        $deleted = $exceptionLog->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = ExceptionLog::find($id);
        $this->assertFalse($found);
    }

    /**
     * testLog
     *
     * @param array $params
     *
     * @dataProvider logDataProvider
     *
     * @return null
     */
    public function testLog($params)
    {
        $id = ExceptionLog::log($params['exception'], $params['location']);
        $this->assertNotEmpty($id);
        $found = ExceptionLog::find($id);
        $found->delete();
    }

    /**
     * testXLog
     *
     * @param array $params
     *
     * @dataProvider logDataProvider
     *
     * @return null
     */
    public function testXLog($params)
    {
        $id = xlog($params['exception'], $params['location']);
        $this->assertNotEmpty($id);
        $found = ExceptionLog::find($id);
        $found->delete();
    }

    /**
     * logDataProvider
     *
     * @return array
     */
    public function logDataProvider()
    {
        $tests = array();

        $tests[] = array(
            'exception' => 'a string',
            'location'  => '',
        );

        $tests[] = array(
            'exception' => array('this', 'is', 'an', 'array'),
            'location'  => 'someplace',
        );

        $tests[] = array(
            'exception' => true,
            'location'  => '',
        );

        $tests[] = array(
            'exception' => new Exception('this is an exception'),
            'location'  => '',
        );

        $testParams = array();
        foreach ($tests as $test) {
            $testParams[] = array($test);
        }

        return $testParams;
    }
}
