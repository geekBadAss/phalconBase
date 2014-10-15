<?php
/**
 * GenController
 *
 * PHP Version 5.3
 *
 * @package   Controllers
 * @author    aidan lydon <alyo@loc.gov>
 * @copyright 2014 The Library of Congress
 * @license   Copyright 2014 The Library of Congress
 * @version   $Id:$
 * @link      TBD
 * @since     Sept 24, 2014
 */
class GenController extends BaseController
{
    /**
     * dmAction
     *
     * @return null
     */
    public function dmAction()
    {
        //TODO: move this to CLI script

        //generate mysql data models
        $db = DB::getConnection();

        $tables = $db->getCol('show tables');

        foreach ($tables as $table) {
            $dmClassName = $table;

            $dmFilePath = __DIR__ . '/../models/data/' . $dmClassName . '.php';

            if (!is_readable($dmFilePath)) {

                if (!is_writable(__DIR__ . '/../models/data/')) {
                    die('please run sudo chmod 777 ' . __DIR__ . '/../models/data/');
                }

                $fields = $db->getAll('describe ' . $table);

                $primary = '{PRIMARY}';
                $primaryType = '{PRIMARY_TYPE}';

                $members = array();
                $nonPrimaryMembers = array();
                $insertBindPositions = array();
                $nonPrimaryFields = array();

                foreach ($fields as $field) {
                    $name = $field['Field'];

                    if ($field['Key'] == 'PRI') {
                        $primary = $name;
                        if (strpos($field['Type'], 'int(') !== false) {
                            $primaryType = 'int';
                        }
                    } else {
                        $nonPrimaryFields[] = $field['Field'];
                        $nonPrimaryMembers[] = $name;
                        $insertBindPositions[] = '?';
                    }

                    $members[] = $name;
                }

                $dataModel = '<?php
/**
 * ' . $dmClassName . '
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
class ' . $dmClassName . ' extends Base implements DataModel
{';
                foreach ($members as $member) {
                    $dataModel .= "\n" . '    protected $' . $member . ';';
                }

                $dataModel .= "\n\n" . '    /**
     * getAll
     *
     * @return array
     */
    public static function getAll()
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $ret = $db->getAll(
                \'SELECT *
                 FROM ' . $table . '\',
                array(),
                __CLASS__
            );

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * find
     *
     * @param ' . $primaryType . ' $' . $primary . '
     *
     * @return '. $dmClassName . '
     */
    public static function find($' . $primary . ')
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $row = $db->getRow(
                \'SELECT *
                 FROM ' . $table . '
                 WHERE ' . $primary . ' = ?\',
                array($' . $primary . ')
            );

            if (!empty($row)) {
                $ret = new ' . $dmClassName . '($row);
            }

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * insert
     *
     * @return int
     */
    public function insert()
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            //insert
            $db->execute(
                \'INSERT INTO ' . $table . '
                 (' . implode(', ', $nonPrimaryFields) . ')
                 VALUES
                 (' . implode(', ', $insertBindPositions) . ')\',
                array(
';
                foreach ($nonPrimaryMembers as $member) {
                    $dataModel .= '                    $this->' . $member . ',' . "\n";
                }

                $dataModel .= '                )
            );

            $this->' . $primary . ' = $db->insertId();

            $ret = $this->' . $primary . ';

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
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
        $ret = false;

        try {
            $db = DB::getConnection();

            //update
            $db->execute(
                \'UPDATE ' . $table . '
                 SET ' . implode(' = ?,' . "\n" . '                 ', $nonPrimaryFields) . ' = ?
                 WHERE ' . $primary . ' = ?\',
                array(
';
                foreach ($nonPrimaryMembers as $member) {
                    $dataModel .= '                    $this->' . $member . ',' . "\n";
                }

                $dataModel .= '
                    $this->' . $primary . ',
                )
            );

            $ret = $db->affectedRows();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }

    /**
     * delete
     *
     * @return int
     */
    public function delete()
    {
        $ret = false;

        try {
            $db = DB::getConnection();

            $db->execute(
                \'DELETE FROM ' . $table . '
                 WHERE ' . $primary . ' = ?\',
                array($this->' . $primary . ')
            );

            $ret = $db->affectedRows();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            xlog($e);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }
}
';
                file_put_contents($dmFilePath, $dataModel);
            }
        }

        die('finished');
    }
}
