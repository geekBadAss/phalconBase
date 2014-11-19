<?php
/**
 * BaseUnitTest
 *
 * Tests
 * @author  aidan lydon <aidanlydon@gmail.com>
 */
abstract class BaseUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * setUp
     *
     * @return null
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown
     *
     * @return null
     */
    public function tearDown()
    {
        parent::tearDown();
    }

    /**
     * _makeMethodAccessible
     *
     * @param string $object - object
     * @param string $method - method name
     *
     * @return accessible method
     */
    protected function _makeMethodAccessible($object, $method)
    {
        $accessibleMethod = null;
        $class = get_class($object);

        if (method_exists($class, $method)) {
            $accessibleMethod = new ReflectionMethod($class, $method);
            $accessibleMethod->setAccessible(true);
        } else {
            throw new Exception('Method "' . $class . '::' . $method. '" does not exist');
        }

        return $accessibleMethod;
    }

    /**
     * _makePropertyAccessible
     *
     * @param string $object   - object
     * @param string $property - property
     *
     * @return accessible property
     */
    protected function _makePropertyAccessible($object, $property)
    {
        $accessiblePropery = null;
        $class = get_class($object);

        if (property_exists($class, $property)) {
            $accessiblePropery = new ReflectionProperty($class, $property);
            $accessiblePropery->setAccessible(true);
        } else {
            throw new Exception('Propery "' . $class . '::' . $property . '" does not exist');
        }

        return $accessiblePropery;
    }
}
