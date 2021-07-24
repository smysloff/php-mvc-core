<?php

declare(strict_types=1);

namespace smysloff\phpmvc\exceptions;

use Exception;

/**
 * Class ForbiddenException
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\exeptions
 */
class ForbiddenException extends Exception
{
    /**
     * @var string
     */
    protected $message = 'У вас нет прав для доступа к этой странице';

    /**
     * @var int
     */
    protected $code = 403;
}
