<?php
/**
 * UserTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class UserTest extends BaseUnitTest
{
    /**
     * testGetAll
     *
     * @return null
     */
    public function testGetAll()
    {
        $users = User::getAll();
        $this->assertContainsOnly('User', $users);
    }

    /**
     * testFind
     *
     * @return null
     */
    public function testFind()
    {
        $user = new User(array(
            'username'  => 'TESTUSER',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');

        $id = $user->insert();

        $found = User::find($id);
        $this->assertInstanceOf('User', $found);

        $deleted = $user->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testFindByUsername
     *
     * @return null
     */
    public function testFindByUsername()
    {
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');
        $id = $user->insert();

        $found = User::findByUsername('test username');
        $this->assertInstanceOf('User', $found);

        $deleted = $user->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testFindByEmail
     *
     * @return null
     */
    public function testFindByEmail()
    {
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');
        $id = $user->insert();

        $found = User::findByEmail('test email address');
        $this->assertInstanceOf('User', $found);

        $deleted = $user->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testInsert
     *
     * @return null
     */
    public function testInsert()
    {
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');
        $id = $user->insert();
        $this->assertEquals($id, $user->id);

        $found = User::find($id);
        $this->assertInstanceOf('User', $found);

        $deleted = $user->delete();
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
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');
        $id = $user->insert();

        //change something
        $newUsername = 'test username changed';
        $user->username = $newUsername;

        //update
        $updated = $user->update();
        $this->assertEquals(1, $updated);

        //find
        $found = User::find($id);
        $this->assertEquals($newUsername, $found->username);

        //clean up
        $deleted = $user->delete();
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
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');
        $id = $user->insert();

        //find
        $found = User::find($id);
        $this->assertInstanceOf('User', $found);

        //delete
        $deleted = $user->delete();
        $this->assertEquals(1, $deleted);

        //find again, should be false
        $found = User::find($id);
        $this->assertFalse($found);
    }

    /**
     * testUsernameIsUnique
     *
     * @return null
     */
    public function testUsernameIsUnique()
    {
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');

        $this->assertTrue($user->usernameIsUnique());

        $id = $user->insert();

        $this->assertTrue($user->usernameIsUnique());

        $deleted = $user->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testGetUserOptions
     *
     * @return null
     */
    public function testGetUserOptions()
    {
        $userOptions = User::getUserOptions();
        $this->assertNotEmpty($userOptions);
    }

    /**
     * testValidatePassword
     *
     * @return null
     */
    public function testValidatePassword()
    {
        $user = new User(array(
            'username'  => 'test username',
            'firstName' => 'test first name',
            'lastName'  => 'test last name',
            'email'     => 'test email address',
            'phone'     => 7075551212,
            'address'   => 'test address',
            'city'      => 'test city',
            'state'     => 'test state',
            'zip'       => 12345,
            'active'    => 0,
        ));
        $user->createHash('test password');

        $valid = $user->validatePassword('test password');
        $this->assertTrue($valid);

        $notValid = $user->validatePassword('something else');
        $this->assertFalse($notValid);
    }
}
