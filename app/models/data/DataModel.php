<?php
/**
 * DataModel
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
interface DataModel
{
    /**
     * getAll - get all rows from a table
     *
     * @return RS
     */
    public static function getAll();

    /**
     * find - get one row from a table
     *
     * @param int $primary
     *
     * @return model object
     */
    public static function find($primary);

    /**
     * insert - insert a row
     *
     * @return int - inserted id
     */
    public function insert();

    /**
     * update - update a row
     *
     * @return int - number of updated rows
     */
    public function update();

    /**
     * delete - delete a row
     *
     * @return int - number of deleted rows
     */
    public function delete();
}
