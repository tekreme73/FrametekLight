<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
namespace FrametekLight\Interfaces;

/**
 * PersistentInterface
 *
 * This interface
 *
 * @package FrametekLight
 * @author Rémi Rebillard
 */
interface PersistentInterface
{

    /**
     *
     * @param boolean $force[optional]            
     */
    public function generateDefault($force = FALSE);

    /**
     */
    public function getPath();

    /**
     *
     * @param string $key            
     * @param boolean $default[optional]            
     */
    public function value($key, $default = NULL);

    /**
     */
    public function loadAll();
}