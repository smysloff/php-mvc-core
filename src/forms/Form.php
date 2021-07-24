<?php

declare(strict_types=1);

namespace smysloff\phpmvc\forms;

use smysloff\phpmvc\Model;

/**
 * Class Form
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\form
 */
class Form
{
    /**
     * @param array $attributes
     * @return Form
     */
    public static function begin(array $attributes): Form
    {
        $tag = '<form';
        foreach ($attributes as $key => $value) {
            if (!empty($value)) {
                $tag .= sprintf(' %s="%s"', $key, $value);
            }
        }
        echo $tag . '>' . PHP_EOL;
        return new Form();
    }

    /**
     * @param string $value
     * @return string
     */
    public function submit(string $value): string
    {
        return "<button type=\"submit\" class=\"btn btn-primary\">$value</button>" . PHP_EOL;
    }

    /**
     * @return void
     */
    public static function end(): void
    {
        echo '</form>' . PHP_EOL;
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @return InputField
     */
    public function field(Model $model, string $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}
