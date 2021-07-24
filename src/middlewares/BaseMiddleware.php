<?php

declare(strict_types=1);

namespace smysloff\phpmvc\middlewares;

/**
 * Class BaseMiddleware
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\middlewares
 */
abstract class BaseMiddleware
{
    /**
     * @return mixed
     */
    abstract public function execute(): void;
}
