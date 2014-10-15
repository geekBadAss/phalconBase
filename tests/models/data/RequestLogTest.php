<?php
/**
 * RequestLogTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class RequestLogTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $requestLogs = RequestLog::getAll();
        $this->assertContainsOnly('RequestLog', $requestLogs);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $requestLog = new RequestLog(
            array(
                'uri'           => 'test uri',
                'params'        => 'test params',
                'dateTime'      => date('Y-m-d H:i:s'),
                'ipAddress'     => 'test ip address',
                'userAgent'     => 'test user agent',
                'module'        => 'test module',
                'controller'    => 'test controller',
                'action'        => 'test action',
                'userId'        => 0,
                'userSessionId' => 0,
            )
        );
        $id = $requestLog->insert();

        $found = RequestLog::find($id);
        $this->assertInstanceOf('RequestLog', $found);

        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $requestLog = new RequestLog(
            array(
                'uri'           => 'test uri',
                'params'        => 'test params',
                'dateTime'      => date('Y-m-d H:i:s'),
                'ipAddress'     => 'test ip address',
                'userAgent'     => 'test user agent',
                'module'        => 'test module',
                'controller'    => 'test controller',
                'action'        => 'test action',
                'userId'        => 0,
                'userSessionId' => 0,
            )
        );
        $id = $requestLog->insert();
        $this->assertEquals($id, $requestLog->id);

        $found = RequestLog::find($id);
        $this->assertInstanceOf('RequestLog', $found);

        $deleted = $requestLog->delete();
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
        $requestLog = new RequestLog(
            array(
                'uri'           => 'test uri',
                'params'        => 'test params',
                'dateTime'      => date('Y-m-d H:i:s'),
                'ipAddress'     => 'test ip address',
                'userAgent'     => 'test user agent',
                'module'        => 'test module',
                'controller'    => 'test controller',
                'action'        => 'test action',
                'userId'        => 0,
                'userSessionId' => 0,
            )
        );
        $id = $requestLog->insert();

        //change something
        $newParams = 'test params changed';
        $requestLog->params = $newParams;

        //update
        $updated = $requestLog->update();
        $this->assertEquals(1, $updated);

        //find
        $found = RequestLog::find($id);
        $this->assertEquals($newParams, $found->params);

        //clean up
        $deleted = $requestLog->delete();
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
        $requestLog = new RequestLog(
            array(
                'uri'           => 'test uri',
                'params'        => 'test params',
                'dateTime'      => date('Y-m-d H:i:s'),
                'ipAddress'     => 'test ip address',
                'userAgent'     => 'test user agent',
                'module'        => 'test module',
                'controller'    => 'test controller',
                'action'        => 'test action',
                'userId'        => 0,
                'userSessionId' => 0,
            )
        );
        $id = $requestLog->insert();

        //find
        $found = RequestLog::find($id);
        $this->assertInstanceOf('RequestLog', $found);

        //delete
        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = RequestLog::find($id);
        $this->assertFalse($found);
    }
}
