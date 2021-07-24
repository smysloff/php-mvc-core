<?php

declare(strict_types=1);

namespace smysloff\phpmvc;

/**
 * Class Session
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
class Session
{
    /**
     *
     */
    protected const FLASH_KEY = 'flash_messages';

    /**
     * Session constructor
     */
    public function __construct()
    {
        session_start();
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as &$flashMessage) {
            // mark to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * Session destructor
     */
    public function __destruct()
    {
        // iterate over marked to be removed flash-messages
        // and remove them
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return string|false
     */
    public function get(string $key): string|false
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * @param string $key
     */
    public function remove(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @param string $message
     */
    public function setFlash(string $key, string $message): void
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'message' => $message,
            'remove' => false,
        ];
    }

    /**
     * @param string $key
     * @return string|false
     */
    public function getFlash(string $key): string|false
    {
        return $_SESSION[self::FLASH_KEY][$key]['message'] ?? false;
    }
}
