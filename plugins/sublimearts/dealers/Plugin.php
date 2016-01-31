<?php namespace SublimeArts\Dealers;

use App;
use Event;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;
use SublimeArts\Dealers\Models\MailBlocker;

/**
 * Dealers Plugin Information File
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
            'name'        => 'Dealers',
            'description' => 'Provides "Dealer" management functionality.',
            'author'      => 'SublimeArts for VerveTronix',
            'homepage'    => 'http://www.sublimearts.me',
            'icon'        => 'icon-user'
        ];
    }

    public $require = ['RainLab.Location'];

    public function register()
    {
        
    }

    public function registerComponents()
    {
        return [
            
        ];
    }

    public function registerPermissions()
    {
        return [
            'sublimearts.dealers.access_dealers' => ['tab' => 'Dealers', 'label' => 'Allow access to Dealers Management'],
            'sublimearts.dealers.access_groups' => ['tab' => 'Dealers', 'label' => 'Allow access to Dealer Group Management'],
            'sublimearts.dealers.access_settings' => ['tab' => 'Dealers', 'label' => 'Allow access to Backend Dealer Settings']
        ];
    }

    public function registerNavigation()
    {
        return [
            'dealers' => [
                'label'       => 'Dealers',
                'url'         => Backend::url('sublimearts/dealers/dealers'),
                'icon'        => 'icon-user',
                'permissions' => ['sublimearts.dealers.*'],
                'order'       => 500,
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Dealer Settings',
                'description' => 'Manage Dealers based Settings.',
                'category'    => 'Dealers',
                'icon'        => 'icon-cog',
                'class'       => 'SublimeArts\Dealers\Models\Settings',
                'order'       => 500,
                'permissions' => ['sublimearts.dealers.access_settings']
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'sublimearts.dealers::mail.activate'   => 'Activation email sent to new dealers.',
            'sublimearts.dealers::mail.welcome'    => 'Welcome email sent when a dealer is activated.',
            'sublimearts.dealers::mail.restore'    => 'Password reset instructions for front-end dealers.',
            'sublimearts.dealers::mail.new_dealer' => 'Sent to administrators when a new dealer joins.',
            'sublimearts.dealers::mail.reactivate' => 'Notification for dealers who reactivate their account.',
        ];
    }

}
