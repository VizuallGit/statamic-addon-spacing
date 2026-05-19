<?php

namespace Vizuall\Spacing\Fieldtypes;

use Statamic\Fields\Fieldtype;

class SpacingSides extends Fieldtype
{
    protected static $handle = 'spacing_sides';

    public function component(): string
    {
        return 'spacing-sides';
    }

    protected function configFieldItems(): array
    {
        return [
            'unit' => [
                'display' => __('Unit'),
                'type'    => 'select',
                'options' => ['px' => 'px', 'rem' => 'rem', 'em' => 'em', '%' => '%'],
                'default' => 'px',
                'width'   => 25,
            ],
            'min' => [
                'display' => __('Min'),
                'type'    => 'integer',
                'default' => 0,
                'width'   => 25,
            ],
            'max' => [
                'display' => __('Max'),
                'type'    => 'integer',
                'default' => 200,
                'width'   => 25,
            ],
            'step' => [
                'display' => __('Step'),
                'type'    => 'integer',
                'default' => 1,
                'width'   => 25,
            ],
        ];
    }

    public function preProcess($value): array
    {
        if (is_array($value) && count($value) > 0) {
            return $value;
        }
        return [['sides' => ['top'], 'value' => $this->config('min', 0), 'custom' => false]];
    }

    public function augment($value): array
    {
        if (!is_array($value)) {
            return [];
        }
        return collect($value)->map(function ($row) {
            $sides = (array) ($row['sides'] ?? []);
            return [
                'sides'  => $sides,
                'value'  => $row['value'] ?? null,
                'custom' => (bool) ($row['custom'] ?? false)
                    || (isset($row['value']) && is_string($row['value']) && !is_numeric($row['value'])),
                'top'    => in_array('top',    $sides),
                'right'  => in_array('right',  $sides),
                'bottom' => in_array('bottom', $sides),
                'left'   => in_array('left',   $sides),
            ];
        })->all();
    }

    public function process($value): array
    {
        if (!is_array($value)) {
            return [];
        }
        $step = $this->config('step', 1);
        $useFloat = strpos((string) $step, '.') !== false;
        return collect($value)
            ->map(function ($row) use ($useFloat) {
                $val = $row['value'] ?? null;
                // Treat as custom if flagged, or if value is a non-numeric string
                $isCustom = (bool) ($row['custom'] ?? false)
                    || (is_string($val) && !is_numeric($val));
                if (!$isCustom) {
                    $val = $useFloat ? (float) $val : (int) $val;
                } else {
                    // Force string so YAML always quotes it, preventing integer round-trip
                    $val = (string) $val;
                }
                return [
                    'sides'  => array_values((array) $row['sides']),
                    'value'  => $val,
                    'custom' => $isCustom,
                ];
            })
            ->values()
            ->all();
    }
}
