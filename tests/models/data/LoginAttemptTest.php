<?php
/**
 * LoginAttemptTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class LoginAttemptTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $loginAttempts = LoginAttempt::getAll();
        $this->assertContainsOnly('LoginAttempt', $loginAttempts);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $loginAttempt = new LoginAttempt(
            array(
                'username'      => 'test username',
                'ipAddress'     => 'test ip address',
                'status'        => 'test status',
                'dateTime'      => date('Y-m-d H:i:s'),
                'userSessionId' => 0,
            )
        );
        $id = $loginAttempt->insert();

        $found = LoginAttempt::find($id);
        $this->assertInstanceOf('LoginAttempt', $found);

        $deleted = $loginAttempt->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $loginAttempt = new LoginAttempt(
            array(
                'username'      => 'test username',
                'ipAddress'     => 'test ip address',
                'status'        => 'test status',
                'dateTime'      => date('Y-m-d H:i:s'),
                'userSessionId' => 0,
            )
        );
        $id = $loginAttempt->insert();
        $this->assertEquals($id, $loginAttempt->id);

        $found = LoginAttempt::find($id);
        $this->assertInstanceOf('LoginAttempt', $found);

        $deleted = $loginAttempt->delete();
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
        $loginAttempt = new LoginAttempt(
            array(
                'username'      => 'test username',
                'ipAddress'     => 'test ip address',
                'status'        => 'test status',
                'dateTime'      => date('Y-m-d H:i:s'),
                'userSessionId' => 0,
            )
        );
        $id = $loginAttempt->insert();

        //change something
        $newStatus = 'test status changed';
        $loginAttempt->status = $newStatus;

        //update
        $updated = $loginAttempt->update();
        $this->assertEquals(1, $updated);

        //find
        $found = LoginAttempt::find($id);
        $this->assertEquals($newStatus, $found->status);

        //clean up
        $deleted = $loginAttempt->delete();
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
        $loginAttempt = new LoginAttempt(
            array(
                'username'      => 'test username',
                'ipAddress'     => 'test ip address',
                'status'        => 'test status',
                'dateTime'      => date('Y-m-d H:i:s'),
                'userSessionId' => 0,
            )
        );
        $id = $loginAttempt->insert();

        //find
        $found = LoginAttempt::find($id);
        $this->assertInstanceOf('LoginAttempt', $found);

        //delete
        $deleted = $loginAttempt->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = LoginAttempt::find($id);
        $this->assertFalse($found);
    }
}
