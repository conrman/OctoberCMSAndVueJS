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
        $alias = AliasLoader::getInstance();
        $alias->alias('Auth', 'SublimeArts\Models\Facades\Auth');

        App::singleton('dealer.auth', function() {
            return \SublimeArts\Models\Classes\AuthManager::instance();
        });

        /*
         * Apply dealer-based mail blocking
         */
        Event::listen('mailer.prepareSend', function($mailer, $view, $message){
            return MailBlocker::filterMessage($view, $message);
        });
    }

    public function registerComponents()
    {
        return [
            'SublimeArts\Dealers\Components\Session'       => 'session',
            'SublimeArts\Dealers\Components\Account'       => 'account',
            'SublimeArts\Dealers\Components\ResetPassword' => 'resetPassword'
        ];
    }

    public function registerPermissions()
    {
        return [
            'sublimearts.dealers.access_dealers' => ['tab' => 'sublimearts.dealers::lang.plugin.tab', 'label' => 'sublimearts.dealers::lang.plugin.access_dealers'],
            'sublimearts.dealers.access_groups' => ['tab' => 'sublimearts.dealers::lang.plugin.tab', 'label' => 'sublimearts.dealers::lang.plugin.access_groups'],
            'sublimearts.dealers.access_settings' => ['tab' => 'sublimearts.dealers::lang.plugin.tab', 'label' => 'sublimearts.dealers::lang.plugin.access_settings']
        ];
    }

    public function registerNavigation()
    {
        return [
            'dealers' => [
                'label'       => 'sublimearts.dealers::lang.dealers.menu_label',
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
                'label'       => 'sublimearts.dealers::lang.settings.menu_label',
                'description' => 'sublimearts.dealers::lang.settings.menu_description',
                'category'    => 'sublimearts.dealers::lang.settings.dealers',
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
