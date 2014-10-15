<?php
/**
 * Memory
 *
 * @package Lib
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
class Memory extends Singleton
{
    protected static $instance;

    private $_host = 'localhost';
    private $_port = '11211';
    private $_enabled = false;
    private $_isInitialized = false;
    private $_mem = null;
    private $_memcachedServers;
    private $_profiler;
    private $_profileType;

    /**
     * __construct
     *
     * @return $this
     */
    protected function __construct()
    {
        //TODO: get this from config
        $config = array(
            'enabled' => true,
            'host' => 'localhost',
            'port' => 11211,
        );

        $this->_enabled = $config['enabled'];

        if ($this->_enabled) {
            $this->_memcachedServers = array();

            if (is_array($config['host'])) {
                $ct = count($config['host']);
                for ($i = 0; $i < $ct; $i++) {
                    $this->_memcachedServers[] = array(
                        'host' => $config['host'][$i],
                        'port' => $config['port'][$i],
                    );
                }
            } else {
                $this->_memcachedServers[] = array(
                    'host' => $this->_host,
                    'port' => $this->_port,
                );
            }

            $this->_mem = new Memcached();
            if (!is_null($this->_mem) && count($this->_memcachedServers) > 0) {
                foreach ($this->_memcachedServers as $s) {
                    $this->_mem->addServer($s['host'], $s['port']);
                }
                $this->_isInitialized = true;
            }
        }

        $this->_profiler = Profiler::getInstance();
        $this->_profileType = Profiler::TYPE_CACHE;
    }

    /**
     * set
     *
     * @param string $key   - cache key
     * @param mixed  $value - value
     * @param int    $ttl   - time to live (in seconds)
     *
     * @return null
     */
    public static function set($key, $value, $ttl = 1800)
    {
        $instance = static::getInstance();
        return $instance->_set($key, $value, $ttl);
    }

    /**
     * _set
     *
     * @param string $key   - cache key
     * @param mixed  $value - value
     * @param int    $ttl   - time to live (in seconds)
     *
     * @return null
     */
    private function _set($key, $value, $ttl)
    {
        if ($this->_enabled && $this->_isInitialized) {
            $profileId = $this->_profiler->start($this->_profileType, 'setting ' . $key);

            $this->_mem->set($key, $value, $ttl);

            $this->_profiler->end($this->_profileType, $profileId, 'set');
        }
    }

    /**
     * get
     *
     * @param string $key - cache key
     *
     * @return null
     */
    public static function get($key)
    {
        $instance = static::getInstance();
        return $instance->_get($key);
    }

    /**
     * get
     *
     * @param string $key
     *
     * @return mixed
     */
    private function _get($key)
    {
        $ret = false;

        if ($this->_enabled && $this->_isInitialized) {
            $profileId = $this->_profiler->start($this->_profileType, 'getting ' . $key);

            $tmp = $this->_mem->get($key);
            $code = $this->_mem->getResultCode();
            if ($code == Memcached::RES_SUCCESS) {
                $ret = $tmp;

                $this->_profiler->end($this->_profileType, $profileId, 'data found');

            } else {
                $this->_profiler->end($this->_profileType, $profileId, 'no data found');
            }
        }

        return $ret;
    }

    /**
     * delete
     *
     * @param mixed $keys
     *
     * @return null
     */
    public static function delete($keys = null)
    {
        $instance = static::getInstance();
        return $instance->_delete($keys);
    }

    /**
     * _delete
     *
     * @param mixed $keys
     *
     * @return null
     */
    private function _delete($keys = null)
    {
        if ($this->_enabled && $this->_isInitialized) {
            if (is_null($keys)) {
                //no keys, flush the cache
                $this->flush();

            } else if (is_array($keys)) {
                //array of keys, delete them
                $profileId = $this->_profiler->start(
                    $this->_profileType,
                    'deleting keys: ' . print_r($keys, true)
                );

                foreach ($keys as &$key) {
                    $this->_mem->delete($key);
                }

                $this->_profiler->end($this->_profileType, $profileId);

            } else {
                //single key, delete it
                $profileId = $this->_profiler->start(
                    $this->_profileType,
                    'invalidating a single key: ' . $keys
                );

                $this->_mem->delete($keys);

                $this->_profiler->end($this->_profileType, $profileId);
            }
        }
    }

    /**
     * flush
     *
     * @return null
     */
    public function flush()
    {
        $profileId = $this->_profiler->start($this->_profileType, 'flushing cache');

        $this->_mem->flush();

        $this->_profiler->end($this->_profileType, $profileId);
    }
}
