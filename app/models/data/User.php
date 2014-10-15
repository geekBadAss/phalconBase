<?php
/**
 * User
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class User extends BaseDataModel implements DataModel
{
    const PBKDF2_HASH_ALGORITHM = 'sha512';
    const PBKDF2_ITERATIONS = 1000;
    const PBKDF2_SALT_BYTE_SIZE = 24;
    const PBKDF2_HASH_BYTE_SIZE = 24;

    const HASH_SECTIONS = 4;
    const HASH_ALGORITHM_INDEX = 0;
    const HASH_ITERATION_INDEX = 1;
    const HASH_SALT_INDEX      = 2;
    const HASH_PBKDF2_INDEX    = 3;

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
        // format: algorithm:iterations:salt:hash
        $salt = base64_encode(
            mcrypt_create_iv(
                self::PBKDF2_SALT_BYTE_SIZE,
                MCRYPT_DEV_URANDOM
            )
        );

        $this->hash = self::PBKDF2_HASH_ALGORITHM . ':' .
            self::PBKDF2_ITERATIONS . ':' .
            $salt . ':' .
            base64_encode(
                $this->_pbkdf2(
                    self::PBKDF2_HASH_ALGORITHM,
                    $password,
                    $salt,
                    self::PBKDF2_ITERATIONS,
                    self::PBKDF2_HASH_BYTE_SIZE,
                    true
                )
            );

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
        $ret = false;

        $params = explode(':', $this->hash);

        if (count($params) === self::HASH_SECTIONS) {
            $pbkdf2 = base64_decode($params[self::HASH_PBKDF2_INDEX]);
            $ret = $this->_slowEquals(
                $pbkdf2,
                $this->_pbkdf2(
                    $params[self::HASH_ALGORITHM_INDEX],
                    $password,
                    $params[self::HASH_SALT_INDEX],
                    intval($params[self::HASH_ITERATION_INDEX]),
                    strlen($pbkdf2),
                    true
                )
            );
        }

        return $ret;
    }

    /**
     * _slowEquals - compares two strings $a and $b in length-constant time.
     *
     * @param string $a - one string
     * @param string $b - another string
     *
     * @return boolean
     */
    private function _slowEquals($a, $b)
    {
        $diff = strlen($a) ^ strlen($b);
        for ($i = 0; $i < strlen($a) && $i < strlen($b); $i++) {
            $diff |= ord($a[$i]) ^ ord($b[$i]);
        }
        return $diff === 0;
    }

    /**
     * _pbkdf2 - PBKDF2 key derivation function as defined by RSA's PKCS #5:
     *   https://www.ietf.org/rfc/rfc2898.txt
     *
     * Returns: A $keyLength-byte key derived from the password and salt.
     *
     * Test vectors can be found here: https://www.ietf.org/rfc/rfc6070.txt
     *
     * This implementation of PBKDF2 was originally created by https://defuse.ca
     * With improvements by http://www.variations-of-shadow.com
     *
     * @param string  $algorithm - The hash algorithm to use. Recommended: SHA256
     * @param string  $password  - The password.
     * @param string  $salt      - A salt that is unique to the password.
     * @param int     $count     - Iteration count. Higher is better, but slower. Recommended:
     *                             At least 1000.
     * @param int     $keyLength - The length of the derived key in bytes.
     * @param boolean $rawOutput - If true, the key is returned in raw binary format. Hex encoded
     *                             otherwise.
     *
     * @return string
     */
    private function _pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput = false)
    {
        //@codeCoverageIgnoreStart
        $algorithm = strtolower($algorithm);

        if (!in_array($algorithm, hash_algos(), true)) {
            trigger_error('PBKDF2 ERROR: Invalid hash algorithm.', E_USER_ERROR);
        }

        if ($count <= 0 || $keyLength <= 0) {
            trigger_error('PBKDF2 ERROR: Invalid parameters.', E_USER_ERROR);
        }

        if (function_exists('hash_pbkdf2')) {
            // The output length is in NIBBLES (4-bits) if $rawOutput is false!
            if (!$rawOutput) {
                $keyLength = $keyLength * 2;
            }

            return hash_pbkdf2($algorithm, $password, $salt, $count, $keyLength, $rawOutput);
        }

        $hashLength = strlen(hash($algorithm, '', true));
        $blockCount = ceil($keyLength / $hashLength);

        $output = "";
        for ($i = 1; $i <= $blockCount; $i++) {
            // $i encoded as 4 bytes, big endian.
            $last = $salt . pack('N', $i);
            // first iteration
            $last = $xorsum = hash_hmac($algorithm, $last, $password, true);
            // perform the other $count - 1 iterations
            for ($j = 1; $j < $count; $j++) {
                $xorsum ^= ($last = hash_hmac($algorithm, $last, $password, true));
            }
            $output .= $xorsum;
        }

        if ($rawOutput) {
            $ret = substr($output, 0, $keyLength);
        } else {
            $ret = bin2hex(substr($output, 0, $keyLength));
        }

        return $ret;
        //@codeCoverageIgnoreEnd
    }
}
