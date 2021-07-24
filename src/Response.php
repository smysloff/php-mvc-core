<?php

declare(strict_types=1);

namespace smysloff\phpmvc;

/**
 * Class Response
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
class Response
{
    /**
     * @param int $code
     */
    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    /**
     * @param string $url
     * @return bool
     */
    public function redirect(string $url): bool
    {
        header("Location: $url");
        return true;
    }
}
