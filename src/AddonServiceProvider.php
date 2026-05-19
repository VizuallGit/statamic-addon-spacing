<?php

namespace Vizuall\Spacing;

use Statamic\Providers\AddonServiceProvider as BaseAddonServiceProvider;

class AddonServiceProvider extends BaseAddonServiceProvider
{
    protected $fieldtypes = [
        Fieldtypes\Spacing::class,
        Fieldtypes\SpacingSides::class,
    ];

    public function bootAddon(): void
    {
        $this->registerScript(__DIR__.'/../resources/js/addon.js');
    }
}
