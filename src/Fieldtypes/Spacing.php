<?php

namespace Vizuall\Spacing\Fieldtypes;

use Statamic\Fields\Fieldtype;

class Spacing extends Fieldtype
{
    protected static $handle = 'spacing';

    public function component(): string
    {
        return 'spacing';
    }

    protected function configFieldItems(): array
    {
        return [
            'side' => [
                'display'      => __('Side'),
                'instructions' => __('Which side of the box is highlighted in the icon.'),
                'type'         => 'select',
                'options'      => ['top' => 'Top', 'right' => 'Right', 'bottom' => 'Bottom', 'left' => 'Left'],
                'default'      => 'top',
                'width'        => 50,
            ],
            'unit' => [
                'display' => __('Unit'),
                'type'    => 'select',
                'options' => ['px' => 'px', 'rem' => 'rem', 'em' => 'em', '%' => '%'],
                'default' => 'px',
                'width'   => 50,
            ],
            'min' => [
                'display' => __('Min'),
                'type'    => 'integer',
                'default' => 0,
                'width'   => 33,
            ],
            'max' => [
                'display' => __('Max'),
                'type'    => 'integer',
                'default' => 200,
                'width'   => 33,
            ],
            'step' => [
                'display' => __('Step'),
                'type'    => 'integer',
                'default' => 1,
                'width'   => 33,
            ],
        ];
    }

    public function preProcess($value): int|float|string
    {
        if (is_string($value) && !is_numeric($value)) {
            return $value;
        }
        return $value ?? $this->config('min', 0);
    }

    public function process($value): int|float|string
    {
        if (is_string($value) && !is_numeric($value)) {
            return $value;
        }
        $step = $this->config('step', 1);
        return strpos((string) $step, '.') !== false ? (float) $value : (int) $value;
    }
}
