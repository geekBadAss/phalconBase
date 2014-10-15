<?php
/**
 * RequestLog
 *
 * PHP Version 5.3
 *
 * @package   DataModels
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class RequestLog extends BaseDataModel implements DataModel
{
    protected $id;
    protected $uri;
    protected $params;
    protected $dateTime;
    protected $ipAddress;
    protected $userAgent;
    protected $module;
    protected $controller;
    protected $action;
    protected $userId;
    protected $userSessionId;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from RequestLog';

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
                from RequestLog
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
        $sql = 'insert into RequestLog
                (uri, params, dateTime, ipAddress, userAgent, module, controller, action, userId,
                 userSessionId)
                values
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $bind = array(
            $this->uri,
            $this->params,
            $this->dateTime,
            $this->ipAddress,
            $this->userAgent,
            $this->module,
            $this->controller,
            $this->action,
            $this->userId,
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
        $sql = 'update RequestLog
                set uri = ?,
                    params = ?,
                    dateTime = ?,
                    ipAddress = ?,
                    userAgent = ?,
                    module = ?,
                    controller = ?,
                    action = ?,
                    userId = ?,
                    userSessionId = ?
                where id = ?';

        $bind = array(
            $this->uri,
            $this->params,
            $this->dateTime,
            $this->ipAddress,
            $this->userAgent,
            $this->module,
            $this->controller,
            $this->action,
            $this->userId,
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
        $sql = 'delete from RequestLog
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }
}
