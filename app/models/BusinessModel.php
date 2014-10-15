<?php
/**
 * BusinessModel
 *
 * @package BusinessModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class BusinessModel extends Base
{
    protected $data;   //view data
    protected $status; //status messages
    protected $errors; //error messages

    /**
     * __construct
     *
     * @param array $params
     *
     * @return $this
     */
    public function __construct(array $params = null)
    {
        parent::__construct($params);

        $this->data   = array();
        $this->status = array();
        $this->errors = array();

        $this->_init();
    }

    /**
     * _init
     *
     * @return null
     */
    protected function _init()
    {
        //intentionally not declared abstract and left blank
        //optional to override
    }

    /**
     * getAllViewData
     *
     * @return array
     */
    public function getAllViewData()
    {
        return array(
            'data'   => $this->data,
            'status' => $this->status,
            'errors' => $this->errors,
        );
    }

    /**
     * addError - add an error message to be displayed to the client
     *
     * @param string $message
     *
     * @return null
     */
    public function addError($message)
    {
        //TODO: add array keys to error messages for associating them with input parameters
        $this->errors[] = $message;
    }

    /**
     * noErrors - should mean the input is valid... provided the input was validated correctly and
     * error messages were added where appropriate
     *
     * @return boolean
     */
    public function noErrors()
    {
        return empty($this->errors);
    }

    /**
     * addStatus - add a status message to be displayed to the client
     *
     * @param string $message
     *
     * @return null
     */
    public function addStatus($message)
    {
        //TODO: status messages might need to be stored in the session rather than the request to
        //account for redirects, then cleared when read and displayed to the user
        $this->status[] = $message;
    }
}
