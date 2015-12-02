<?php

/**
 * FrametekLight Framework (https://github.com/tekreme73/FrametekLight)
 *
 * @link		https://github.com/tekreme73/FrametekLight
 * @copyright	Copyright (c) 2015 Rémi Rebillard
 * @license		https://github.com/tekreme73/FrametekLight/blob/master/LICENSE (MIT License)
 */
class UploadTestPHPT extends PHPUnit_Extensions_PhptTestSuite
{

    public function __construct()
    {
        parent::__construct(__DIR__);
    }
}
