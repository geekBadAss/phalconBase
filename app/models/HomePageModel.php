<?php
/**
 * HomePageModel
 *
 * @package BusinessModels
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class HomePageModel extends BusinessModel
{
    /**
     * getData
     *
     * @return null
     */
    public function getData()
    {
        //TODO: keys should be generated using a constant somewhere
        $key = 'HomePageData';

        if (!$data = Memory::get($key)) {
            $data = $this->_fetchData();
            Memory::set($key, $data);
        }

        $this->data = array_merge($this->data, $data);
    }

    /**
     * _fetchData
     *
     * @return null
     */
    private function _fetchData()
    {
        $data = array('something' => 'value');

        return $data;
    }
}
