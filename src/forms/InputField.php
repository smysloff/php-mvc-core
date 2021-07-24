<?php

declare(strict_types=1);

namespace smysloff\phpmvc\forms;

use smysloff\phpmvc\Model;

/**
 * Class Field
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\form
 */
class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    /**
     * @var string
     */
    public string $type;

    /**
     * Field constructor
     *
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    /**
     * @return $this
     */
    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf(
            '<input id="%s" type="%s" name="%s" value="%s" class="form-control%s">',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
        );
    }
}
