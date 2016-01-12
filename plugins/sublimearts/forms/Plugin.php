<?php namespace SublimeArts\Forms;

use Backend;
use System\Classes\PluginBase;

/**
 * Forms Plugin Information File
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
            'name'        => 'Forms',
            'description' => 'Provides various Forms that are used',
            'author'      => 'SublimeArts for VerveTronix',
            'homepage'    => 'http://www.sublimearts.me',
            'icon'        => 'icon-align-justify'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'SublimeArts\Forms\Components\ContactForm'      => 'contactForm',
            'SublimeArts\Forms\Components\SubscriptionForm' => 'subscriptionForm'
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
            'sublimearts.forms.some_permission' => [
                'tab' => 'Forms',
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
        return [
            'forms' => [
                'label'       => 'Captured Leads',
                'url'         => Backend::url('sublimearts/forms/leads'),
                'icon'        => 'icon-smile-o',
                'permissions' => ['sublimearts.forms.*'],
                'order'       => 500,
            ],
        ];
    }

}
