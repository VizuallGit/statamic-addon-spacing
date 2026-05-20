<?php

namespace Vizuall\Spacing;

use Statamic\Providers\AddonServiceProvider as BaseAddonServiceProvider;

class AddonServiceProvider extends BaseAddonServiceProvider
{
    protected $fieldtypes = [
        Fieldtypes\Spacing::class,
        Fieldtypes\SpacingSides::class,
    ];

    protected $scripts = [
        __DIR__.'/../resources/js/addon.js',
    ];

    protected $stylesheets = [
        __DIR__.'/../resources/css/addon.css',
    ];
}
