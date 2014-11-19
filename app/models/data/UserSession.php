<?php
/**
 * UserSession
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class UserSession extends BaseDataModel implements DataModel
{
    protected $id;
    protected $phpSessionId;
    protected $loginDate;
    protected $loginTime;
    protected $logoutDate;
    protected $logoutTime;
    protected $userState;
    protected $userId;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from UserSession';

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
                from UserSession
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
        $sql = 'insert into UserSession
                (phpSessionId, loginDate, loginTime, logoutDate, logoutTime, userState, userId)
                values
                (?, ?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->phpSessionId,
            $this->loginDate,
            $this->loginTime,
            $this->logoutDate,
            $this->logoutTime,
            $this->userState,
            $this->userId,
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
        $sql = 'update UserSession
                set phpSessionId = ?,
                    loginDate = ?,
                    loginTime = ?,
                    logoutDate = ?,
                    logoutTime = ?,
                    userState = ?,
                    userId = ?
                where id = ?';

        $bind = array(
            $this->phpSessionId,
            $this->loginDate,
            $this->loginTime,
            $this->logoutDate,
            $this->logoutTime,
            $this->userState,
            $this->userId,
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
        $sql = 'delete from UserSession
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
