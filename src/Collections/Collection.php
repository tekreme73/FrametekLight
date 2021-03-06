<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
namespace FrametekLight\Collections;

use FrametekLight\Interfaces\CollectionInterface;

/**
 * Collection
 *
 * This class
 *
 * @package FrametekLight
 * @author Rémi Rebillard
 */
abstract class Collection implements CollectionInterface
{

    /**
     * ******************************************************************************
     * Collection interface
     * *****************************************************************************
     */
    
    /**
     * Set collection item
     *
     * @param string $key
     *            The data key
     * @param mixed $value
     *            The data value
     */
    public function set($key, $value)
    {
        $this->allByRef()[$key] = $value;
    }

    /**
     * Get collection item for key
     *
     * @param string $key
     *            The data key
     * @param mixed $default[optional]
     *            The default value to return if data key does not exist
     *            
     * @return mixed The key's value, or the default value
     */
    public function get($key, $default = NULL)
    {
        return ($this->has($key)) ? $this->all()[$key] : $default;
    }

    /**
     * Push collection items, add in last place in the collection
     *
     * @param mixed $value
     *            The data value
     */
    public function push($value)
    {
        array_push($this->allByRef(), $value);
    }

    /**
     * Pop collection items, get and remove the last item
     *
     * @return mixed The last item
     */
    public function pop()
    {
        return array_pop($this->allByRef());
    }

    /**
     * Shift collection items, get and remove the first item
     *
     * @return mixed The first item
     */
    public function shift()
    {
        return array_shift($this->allByRef());
    }

    /**
     * Unshift collection items, add in first place in the collection
     *
     * @param mixed $value
     *            The data value
     */
    public function unshift($value)
    {
        array_unshift($this->allByRef(), $value);
    }

    /**
     * Get the first element of the collection
     *
     * @param string $default[optional]
     *            The default value to return if there is not first item
     *            
     * @return mixed the first item
     */
    public function first($default = NULL)
    {
        $first = $this->shift();
        if (! $first) {
            $first = $default;
        } else {
            $this->unshift($first);
        }
        return $first;
    }

    /**
     * Does the collection have a given key?
     *
     * @param string $key
     *            The data key
     *            
     * @return boolean If the collection have the given key
     */
    public function has($key)
    {
        return isset($this->all()[$key]);
    }

    /**
     * Does the collection contain a given key?
     *
     * @param mixed $value
     *            The data value
     * @param boolean $strict[optional]
     *            Check the type too or not
     *            
     * @return boolean If the collection have the given value
     */
    public function contains($value, $strict = TRUE)
    {
        return in_array($value, $this->all(), $strict);
    }

    /**
     * Add item to collection
     *
     * @param array $items
     *            Key-value array of data to append to the collection
     */
    public function replace(array $items)
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * Remove item from collection
     *
     * @param string $key
     *            The data key
     * @param boolean $all[optional]
     *            Specifie if all folders of the key path will be remove or not
     */
    public function remove($key, $all = FALSE)
    {
        if ($this->has($key)) {
            unset($this->all()[$key]);
        }
    }

    /**
     * Remove all items from collection with a list of exception
     *
     * @param array $excepts
     *            The collection's keys to prevent from remove
     */
    public function clear(array $excepts = [])
    {
        $tmp = array();
        foreach ($excepts as $except) {
            if ($this->has($except)) {
                $tmp[$except] = $this->get($except);
            }
        }
        $this->setAll(array());
        foreach ($tmp as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * ******************************************************************************
     * ArrayAccess interface
     * *****************************************************************************
     */
    
    /**
     * Does the collection have a given key?
     *
     * @param string $key
     *            The data key
     *            
     * @return boolean If the collection have the given key
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get collection item for key
     *
     * @param string $key
     *            The data key
     *            
     * @return mixed The key's value, or the default value
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set collection item
     *
     * @param string $key
     *            The data key
     * @param mixed $value
     *            The data value
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Remove item from collection
     *
     * @param string $key
     *            The data key
     */
    public function offsetUnset($key)
    {
        $this->remove($key);
    }

    /**
     * ******************************************************************************
     * Countable interface
     * *****************************************************************************
     */
    
    /**
     * Get number of items in the collection
     *
     * @return integer The number of items in the collection
     *        
     * @see Countable::count()
     */
    public function count()
    {
        return count($this->all());
    }

    /**
     * ******************************************************************************
     * IteratorAggregate interface
     * *****************************************************************************
     */
    
    /**
     * Get collection iterator
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->all());
    }
}
