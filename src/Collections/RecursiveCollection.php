<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
namespace FrametekLight\Collections;

/**
 * RecursiveCollection
 *
 * This class
 *
 * @package FrametekLight
 * @author Rémi Rebillard
 */
abstract class RecursiveCollection extends Collection
{

    /**
     *
     * @var string
     */
    protected $_separator;

    /**
     *
     * @param string $separator[optional]            
     */
    public function __construct($separator = '.')
    {
        $this->setSeparator($separator);
    }

    /**
     * Set separator value for this collection to complete recursion
     *
     * @param string $separator
     *            The collection separator
     */
    public function setSeparator($separator)
    {
        $this->_separator = $separator;
    }

    /**
     * Get separator value for this collection to complete recursion
     *
     * @return string The collection separator
     */
    public function getSeparator()
    {
        return $this->_separator;
    }

    /**
     * Set collection item
     *
     * Warn: Recursive function
     *
     * @param string $key
     *            The data key
     * @param mixed $value
     *            The data value
     * @param array $in
     *            The folder uses for the recursion
     */
    protected function setIn($key, $value, &$in)
    {
        $keys = explode($this->getSeparator(), $key, 2);
        if (count($keys) > 0) {
            if (! isset($in[$keys[0]])) {
                if (count($keys) >= 2) {
                    $in[$keys[0]] = array();
                }
            }
            if (count($keys) >= 2) {
                $this->setIn($keys[1], $value, $in[$keys[0]]);
            } else {
                $in[$keys[0]] = $value;
            }
        }
    }

    /**
     * Get collection item for key
     *
     * Warn: Recursive function
     *
     * @param string $key
     *            The data key
     * @param array $in
     *            The folder uses for the recursion
     *            
     * @return mixed The key's value, or the default value
     */
    protected function getIn($key, $in)
    {
        $keys = explode($this->getSeparator(), $key, 2);
        if (count($keys) <= 0) {
            return '';
        } else 
            if (isset($in[$keys[0]])) {
                if (count($keys) >= 2) {
                    return $this->getIn($keys[1], $in[$keys[0]]);
                } else {
                    return $in[$keys[0]];
                }
            } else {
                return '';
            }
    }

    /**
     * Does the collection have a given key?
     *
     * Warn: Recursive function
     *
     * @param string $key
     *            The data key
     * @param array $in
     *            The folder uses for the recursion
     *            
     * @return boolean If the collection have the given key
     */
    protected function hasIn($key, $in)
    {
        $keys = explode($this->getSeparator(), $key, 2);
        if (count($keys) <= 0) {
            return false;
        } else {
            if (! isset($in[$keys[0]])) {
                return false;
            } else {
                if (count($keys) >= 2) {
                    return true && $this->hasIn($keys[1], $in[$keys[0]]);
                } else {
                    return true;
                }
            }
        }
    }

    /**
     * Does the collection contain a given key?
     *
     * Warn: Recursive function
     *
     * @param mixed $value
     *            The data value
     * @param boolean $strict
     *            Check the type too or not
     * @param array $in
     *            The folder uses for the recursion
     *            
     * @return boolean If the collection have the given value
     */
    protected function containsIn($value, $strict, $in)
    {
        $found = FALSE;
        $keys = array_keys($in);
        for ($i = 0; $i < count($keys) && ! $found; $i ++) {
            $v = $in[$keys[$i]];
            if (($strict === TRUE && $value === $v) || ($strict === FALSE && $value == $v)) {
                $found = TRUE;
            } else 
                if (is_array($v)) {
                    $found = $this->containsIn($value, $strict, $v);
                }
        }
        return $found;
    }

    /**
     * Remove item from collection
     *
     * Warn: Recursive function
     *
     * @param string $key
     *            The data key
     * @param array $in
     *            The folder uses for the recursion
     * @param boolean $all[optional]
     *            Specifie if all folders of the key path will be remove or not
     */
    protected function removeIn($key, &$in, $all = false)
    {
        $keys = explode($this->getSeparator(), $key, 2);
        if (count($keys) >= 0) {
            if (isset($in[$keys[0]])) {
                if (count($keys) >= 2) {
                    $this->removeIn($keys[1], $in[$keys[0]], $all);
                    if ($all && empty($in[$keys[0]])) {
                        unset($in[$keys[0]]);
                    }
                } else {
                    unset($in[$keys[0]]);
                }
            }
        }
    }

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
        $d = $this->all();
        $this->setIn($key, $value, $d);
        $this->setAll($d);
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
        return ($this->has($key)) ? $this->getIn($key, $this->all()) : $default;
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
        return $this->hasIn($key, $this->all());
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
        return $this->containsIn($value, $strict, $this->all());
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
        $d = $this->all();
        $this->removeIn($key, $d, $all);
        $this->setAll($d);
    }
}
