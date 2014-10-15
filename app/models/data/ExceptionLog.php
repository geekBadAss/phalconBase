<?php
/**
 * ExceptionLog
 *
 * @package DataModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class ExceptionLog extends BaseDataModel implements DataModel
{
    protected $id;
    protected $message;
    protected $location;
    protected $object;
    protected $dateTime;

    /**
     * getAll
     *
     * @return RS
     */
    public static function getAll()
    {
        $sql = 'select *
                from ExceptionLog';

        return parent::_getAll($sql, array(), __CLASS__);
    }

    /**
     * find
     *
     * @param int $id
     *
     * @return ExceptionLog
     */
    public static function find($id)
    {
        $sql = 'select *
                from ExceptionLog
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
        $sql = 'insert into ExceptionLog
                (message, location, object, dateTime)
                values
                (?, ?, ?, ?)';

        $bind = array(
            $this->message,
            $this->location,
            $this->object,
            $this->dateTime,
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
        $sql = 'update ExceptionLog
                set message = ?,
                    location = ?,
                    object = ?,
                    dateTime = ?
                where id = ?';

        $bind = array(
            $this->message,
            $this->location,
            $this->object,
            $this->dateTime,
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
        $sql = 'delete from ExceptionLog
                where id = ?';

        return $this->_delete($sql, array($this->id));
    }

    /**
     * log
     *
     * @param mixed  $exception -
     * @param string $location  -
     *
     * @return int
     */
    public static function log($exception, $location = '')
    {
        $ret = false;

        try {
            $projectDir = realpath(__DIR__ . '/../../../') . '/';

            switch (gettype($exception)) {
            case 'integer':
            case 'double':
            case 'string':
                $message = $exception;
                $object = $message;
                break;
            case 'array':
                $message = print_r($exception, true);
                $object = $message;
                break;
            case 'boolean':
            case 'NULL':
            case 'resource':
            default:
                $message = var_export($exception, true);
                $object = $message;
                break;
            case 'object':
                if (method_exists($exception, 'getMessage')
                    && method_exists($exception, 'getFile')
                    && method_exists($exception, 'getLine')
                ) {
                    $message = $exception->getMessage();
                    $location = str_replace($projectDir, '', $exception->getFile()) . ' - line ' .
                        $exception->getLine();
                    $object = $exception;
                } else {
                    $message = print_r($exception, true);
                    $object = $exception;
                }
                break;
            }

            if (empty($location)) {
                $trace = debug_backtrace();

                if (is_array($trace)) {

                    $index = 0;

                    while (isset($trace[$index])) {
                        $t = $trace[$index];

                        $file     = isset($t['file'])     ? $t['file']     : '';
                        $line     = isset($t['line'])     ? $t['line']     : '';
                        $class    = isset($t['class'])    ? $t['class']    : '';
                        $function = isset($t['function']) ? $t['function'] : '';
                        $args     = isset($t['args'])     ? $t['args']     : '';
                        $type     = isset($t['type'])     ? $t['type']     : '';

                        $xlog = strpos($file, $projectDir.'app/lib/Custom/functions.php') !== false
                            && $class . $type . $function == 'ExceptionLog::log';

                        if ($xlog) {
                            //skip this
                            $index++;
                        } else {
                            $location = str_replace($projectDir, '', $file) . ' - line ' . $line;
                            break;
                        }
                    }
                }
            }

            $log = new ExceptionLog(
                array(
                    'message'  => $message,
                    'location' => $location,
                    'object'   => $object,
                    'dateTime' => date('Y-m-d H:i:s')
                )
            );
            $ret = $log->insert();

        } catch (Exception $e) {
            //@codeCoverageIgnoreStart
            pre($e, true);
            //@codeCoverageIgnoreEnd
        }

        return $ret;
    }
}
