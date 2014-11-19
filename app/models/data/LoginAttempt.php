<?php
/**
 * LoginAttempt
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class LoginAttempt extends BaseDataModel implements DataModel
{
    protected $id;
    protected $username;
    protected $ipAddress;
    protected $status;
    protected $dateTime;
    protected $userSessionId;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from LoginAttempt';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return RequestLog
     */
    public static function find($id)
    {
        $sql = 'select *
                from LoginAttempt
                where id = ?';

        return parent::_find($sql, array($id), __CLASS__);
    }

    /**
     * insert
     *
     * @return int
     */
    public function insert()
    {
        $sql = 'insert into LoginAttempt
                (username, ipAddress, status, dateTime, userSessionId)
                values
                (?, ?, ?, ?, ?)';

        $bind = array(
            $this->username,
            $this->ipAddress,
            $this->status,
            $this->dateTime,
            $this->userSessionId,
        );

        $this->id = $this->_insert($sql, $bind);

        return $this->id;
    }

    /**
     * update
     *
     * @return int
     */
    public function update()
    {
        $sql = 'update LoginAttempt
                set username = ?,
                    ipAddress = ?,
                    status = ?,
                    dateTime = ?,
                    userSessionId = ?
                where id = ?';

        $bind = array(
            $this->username,
            $this->ipAddress,
            $this->status,
            $this->dateTime,
            $this->userSessionId,
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
        $sql = 'delete from LoginAttempt
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
