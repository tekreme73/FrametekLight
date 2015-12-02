<?php
/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
namespace FrametekLight\Http;

use FrametekLight\Collections\DataCollection;
use FrametekLight\Exception\UndefinedHttpException;

/**
 * Get
 *
 * This class
 *
 * @package FrametekLight
 * @author Rémi Rebillard
 */
class Get extends DataCollection
{

    /**
     *
     * @throws UndefinedHttpException
     */
    public function __construct()
    {
        parent::__construct();
        if (! isset($_GET)) {
            throw new UndefinedHttpException("GET");
        } else {
            $this->setAll($_GET);
        }
    }
}
