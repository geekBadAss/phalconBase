<?php
/**
 * UserSessionTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class UserSessionTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $userSessions = UserSession::getAll();
        $this->assertContainsOnly('UserSession', $userSessions);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $userSession = new UserSession(
            array(
                'phpSessionId' => 'test session id',
                'loginDate'    => date('Y-m-d'),
                'loginTime'    => date('H:i:s'),
                'logoutDate'   => date('Y-m-d'),
                'logoutTime'   => date('H:i:s'),
                'userState'    => 'logged out',
                'userId'       => 0,
            )
        );
        $id = $userSession->insert();

        $found = UserSession::find($id);
        $this->assertInstanceOf('UserSession', $found);

        $deleted = $userSession->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $userSession = new UserSession(
            array(
                'phpSessionId' => 'test session id',
                'loginDate'    => date('Y-m-d'),
                'loginTime'    => date('H:i:s'),
                'logoutDate'   => date('Y-m-d'),
                'logoutTime'   => date('H:i:s'),
                'userState'    => 'logged out',
                'userId'       => 0,
            )
        );
        $id = $userSession->insert();
        $this->assertEquals($id, $userSession->id);

        $found = UserSession::find($id);
        $this->assertInstanceOf('UserSession', $found);

        $deleted = $userSession->delete();
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
        $userSession = new UserSession(
            array(
                'phpSessionId' => 'test session id',
                'loginDate'    => date('Y-m-d'),
                'loginTime'    => date('H:i:s'),
                'logoutDate'   => date('Y-m-d'),
                'logoutTime'   => date('H:i:s'),
                'userState'    => 'logged out',
                'userId'       => 0,
            )
        );
        $id = $userSession->insert();

        //change something
        $newPhpSessionId = 'test session id changed';
        $userSession->phpSessionId = $newPhpSessionId;

        //update
        $updated = $userSession->update();
        $this->assertEquals(1, $updated);

        //find
        $found = UserSession::find($id);
        $this->assertEquals($newPhpSessionId, $found->phpSessionId);

        //clean up
        $deleted = $userSession->delete();
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
        $userSession = new UserSession(
            array(
                'phpSessionId' => 'test session id',
                'loginDate'    => date('Y-m-d'),
                'loginTime'    => date('H:i:s'),
                'logoutDate'   => date('Y-m-d'),
                'logoutTime'   => date('H:i:s'),
                'userState'    => 'logged out',
                'userId'       => 0,
            )
        );
        $id = $userSession->insert();

        //find
        $found = UserSession::find($id);
        $this->assertInstanceOf('UserSession', $found);

        //delete
        $deleted = $userSession->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = UserSession::find($id);
        $this->assertFalse($found);
    }
}
