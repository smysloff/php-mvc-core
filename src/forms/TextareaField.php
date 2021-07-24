<?php

declare(strict_types=1);

namespace smysloff\phpmvc\forms;

/**
 * Class TextareaField
 *
 * @author Alexander Smyslov <smyslov@selby.su>
 * @package smysloff\phpmvc\forms
 */
class TextareaField extends BaseField
{
    /**
     * @return string
     */
    public function renderInput(): string
    {
        return sprintf(
            '<textarea name="%s" class="form-control%s">%s</textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
        );
    }
}
