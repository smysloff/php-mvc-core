<?php

declare(strict_types=1);

namespace smysloff\phpmvc;

use smysloff\phpmvc\db\DBModel;

/**
 * Class UserModel
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc
 */
abstract class UserModel extends DBModel
{
    /**
     * @return string
     */
    abstract public function getDisplayName(): string;
}
