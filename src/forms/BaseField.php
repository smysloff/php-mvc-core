<?php

declare(strict_types=1);

namespace smysloff\phpmvc\forms;

use smysloff\phpmvc\Model;

/**
 * Class BaseField
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\forms
 */
abstract class BaseField
{
    /**
     * @var Model
     */
    public Model $model;

    /**
     * @var string
     */
    public string $attribute;


    /**
     * @return string
     */
    abstract public function renderInput(): string;

    /**
     * BaseField constructor
     *
     * @param Model $model
     * @param string $attribute
     */
    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return sprintf(
            '<div class="mb-3">
                <label for="%s" class="form-label">%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>' . PHP_EOL,
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}
