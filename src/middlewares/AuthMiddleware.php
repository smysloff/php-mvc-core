<?php

declare(strict_types=1);

namespace smysloff\phpmvc\middlewares;

use smysloff\phpmvc\Application;
use smysloff\phpmvc\exceptions\ForbiddenException;

/**
 * Class AuthMiddleware
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\middlewares
 */
class AuthMiddleware extends BaseMiddleware
{
    /**
     * @var array
     */
    public array $actions = [];

    /**
     * AuthMiddleware constructor
     *
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    /**
     * @throws ForbiddenException
     */
    public function execute(): void
    {
        if (
            Application::isGuest() &&
            in_array(Application::$app->controller->action, $this->actions)
        ) {
            throw new ForbiddenException();
        }
    }
}
