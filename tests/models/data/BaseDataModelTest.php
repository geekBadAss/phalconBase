<?php
/**
 * BaseDataModelTest
 *
 * DataModelTests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class BaseDataModelTest extends BaseUnitTest
{
    //NOTE: getAll, insert, update, delete, and find are tested by each of the child data model
    //classes

    /**
     * testFind - test finding without a class in order to get an array of data rather than an
     * object
     *
     * @return null
     */
    public function testFind()
    {
        //insert something
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

        //create a baseDataModel object
        $baseDataModel = new BaseDataModel();

        //get the _find function
        $_find = $this->_makeMethodAccessible($baseDataModel, '_find');

        $sql = 'select *
                from RequestLog
                where id = ?';

        $bind = array($id);

        //invoke
        $result = $_find->invoke($baseDataModel, $sql, $bind);

        //test the result
        $this->assertEquals($result, $requestLog->toArray());

        //clean up
        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);
    }



    /**
     * testGetOne
     *
     * @return null
     */
    public function testGetOne()
    {
        //insert something
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

        //create a baseDataModel object
        $baseDataModel = new BaseDataModel();

        //get the _getOne function
        $_getOne = $this->_makeMethodAccessible($baseDataModel, '_getOne');

        $sql = 'select id
                from RequestLog
                where id = ?';

        $bind = array($id);

        //invoke
        $result = $_getOne->invoke($baseDataModel, $sql, $bind);

        //test the result
        $this->assertEquals($result, $id);

        //clean up
        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testGetAssoc
     *
     * @return null
     */
    public function testGetAssoc()
    {
        //insert something
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

        //create a baseDataModel object
        $baseDataModel = new BaseDataModel();

        //get the _getAssoc function
        $_getAssoc = $this->_makeMethodAccessible($baseDataModel, '_getAssoc');

        $sql = 'select id, uri
                from RequestLog
                where id = ?';

        $bind = array($id);

        //invoke
        $result = $_getAssoc->invoke($baseDataModel, $sql, $bind);

        //test the result
        $this->assertEquals($result, array($id => 'test uri'));

        //clean up
        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);
    }

    /**
     * testGetCol
     *
     * @return null
     */
    public function testGetCol()
    {
        //insert something
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

        //create a baseDataModel object
        $baseDataModel = new BaseDataModel();

        //get the _getCol function
        $_getCol = $this->_makeMethodAccessible($baseDataModel, '_getCol');

        $sql = 'select id
                from RequestLog
                where id = ?';

        $bind = array($id);

        //invoke
        $result = $_getCol->invoke($baseDataModel, $sql, $bind);

        //test the result
        $this->assertEquals($result, array($id));

        //clean up
        $deleted = $requestLog->delete();
        $this->assertEquals(1, $deleted);
    }
}
