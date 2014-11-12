<?php
/**
 * User
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class User extends BaseDataModel implements DataModel
{
    protected $id;
    protected $username;
    protected $hash;
    protected $firstName;
    protected $lastName;
    protected $email;
    protected $phone;
    protected $address;
    protected $city;
    protected $state;
    protected $zip;
    protected $active;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from User';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return array
     */
    public static function find($id)
    {
        $sql = 'select *
                from User
                where id = ?';

        return parent::_find($sql, array($id), __CLASS__);
    }

    /**
     * findByUsername
     *
     * @param string $username
     *
     * @return User
     */
    public static function findByUsername($username)
    {
        $sql = 'select *
                from User
                where username = ?';

        return parent::_find($sql, array($username), __CLASS__);
    }

    /**
     * findByEmail
     *
     * @param string $email
     *
     * @return User
     */
    public static function findByEmail($email)
    {
        $sql = 'select *
                from User
                where email = ?';

        return parent::_find($sql, array($email), __CLASS__);
    }

    /**
     * insert
     *
     * @return int
     */
    public function insert()
    {
        $ret = false;

        //make sure the username is unique
        if ($this->usernameIsUnique()) {
            $sql = 'insert into User
                    (username, hash, firstName, lastName, email, phone, address, city, state, zip,
                     active)
                    values
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

            $bind = array(
                $this->username,
                $this->hash,
                $this->firstName,
                $this->lastName,
                $this->email,
                $this->phone,
                $this->address,
                $this->city,
                $this->state,
                $this->zip,
                $this->active,
            );

            $this->id = $this->_insert($sql, $bind);

            $ret = $this->id;
        }

        return $ret;
    }

    /**
     * update
     *
     * @return int
     */
    public function update()
    {
        $sql = 'update User
                set username = ?,
                    hash = ?,
                    firstName = ?,
                    lastName = ?,
                    email = ?,
                    phone = ?,
                    address = ?,
                    city = ?,
                    state = ?,
                    zip = ?,
                    active = ?
                where id = ?';

        $bind = array(
            $this->username,
            $this->hash,
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->phone,
            $this->address,
            $this->city,
            $this->state,
            $this->zip,
            $this->active,
            $this->id,
        );

        return $this->_update($sql, $bind);
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete()
    {
        $sql = 'delete from User
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * usernameIsUnique
     *
     * @return boolean
     */
    public function usernameIsUnique()
    {
        $ret = false;

        if (isset($this->id)) {
            $sql = 'select count(*)
                    from User
                    where username = ?
                    and id != ?';

            $bind = array(
                $this->username,
                $this->id,
            );

        } else {
            $sql = 'select count(*)
                    from User
                    where username = ?';

            $bind = array(
                $this->username,
            );
        }

        if (parent::_getOne($sql, $bind) == 0) {
            $ret = true;
        }

        return $ret;
    }

    /**
     * getUserOptions
     *
     * @return array
     */
    public static function getUserOptions()
    {
        $sql = 'select id, username
                from User
                order by username';

        return parent::_getAssoc($sql);
    }

    /**
     * createHash
     *
     * @param string $password
     *
     * @return string
     */
    public function createHash($password)
    {
        $this->hash = password_hash($password, PASSWORD_DEFAULT);
        return true;
    }

    /**
     * validatePassword
     *
     * @param string $password
     *
     * @return boolean
     */
    public function validatePassword($password)
    {
        //initially used: return password_verify($password, $this->hash);
        //but this approach checks every character for equality to protect against timing attacks
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return hash_equals($hash, $this->hash);
    }
}
