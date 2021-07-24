<?php

declare(strict_types=1);

namespace smysloff\phpmvc\exceptions;

use Exception;

/**
 * Class NotFoundException
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\exeptions
 */
class NotFoundException extends Exception
{
    /**
     * @var int
     */
    protected $code = 404;

    /**
     * @var string
     */
    protected $message = 'Page Not Found';
}
