<?php namespace Yfktn\TntSastrawi;

use Backend;
use System\Classes\PluginBase;

/**
 * TntSastrawi Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'TntSastrawi',
            'description' => 'Indonesian Sastrawi and TNT Search Plugin For OctoberCMS.',
            'author'      => 'Yfktn',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Yfktn\TntSastrawi\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'yfktn.tntsastrawi.management' => [
                'tab' => 'TntSastrawi',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'tntsastrawi' => [
                'label'       => 'TntSastrawi',
                'url'         => Backend::url('yfktn/tntsastrawi/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['yfktn.tntsastrawi.*'],
                'order'       => 500,
            ],
        ];
    }
}
