<?php
/**
 * Created by PhpStorm.
 * User: plotnikov
 * Date: 01.06.2017
 * Time: 17:49
 */

namespace ilyaplot\containers;

/**
 * Class Container
 * @package ilyaplot\containers
 *
 * @description
 * Предоставляет простой объектный стиль доступа или array access к массиву
 */
class Container implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array Массив параметров
     */
    protected $_attributes = [];

    /**
     * Container constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->_attributes = $attributes;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name) :bool
    {
        return isset($this->_attributes[$name]);
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        if (!empty($name)) {
            $this->_attributes[$name] = $value;
        } else {
            $this->_attributes[] = $value;
        }
    }

    /**
     * @param $name
     */
    public function __unset($name)
    {
        unset($this->_attributes[$name]);
    }

    /**
     * @return string
     */
    public function __toString() :string
    {
        return json_encode($this->_attributes, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    # Array access

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return $this->__isset($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        return $this->__set($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        return $this->__unset($offset);
    }

    # Countable
    /**
     * @return int
     */
    public function count()
    {
        return count($this->_attributes);
    }

    /**
     * @return \ArrayIterator
     * IteratorAggregate (foreach support)
     */
    public function getIterator() //:\ArrayIterator
    {
        return new \ArrayIterator($this->_attributes);
    }
}