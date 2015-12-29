<?php namespace SublimeArts\Dealers\Components;

use Auth;
use Flash;
use Lang;
use Request;
use Redirect;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use ValidationException;

class Session extends ComponentBase
{
    const ALLOW_ALL = 'all';
    const ALLOW_GUEST = 'guest';
    const ALLOW_DEALER = 'dealer';

    public function componentDetails()
    {
        return [
            'name'        => 'sublimearts.dealers::lang.session.session',
            'description' => 'sublimearts.dealers::lang.session.session_desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'security' => [
                'title'       => 'sublimearts.dealers::lang.session.security_title',
                'description' => 'sublimearts.dealers::lang.session.security_desc',
                'type'        => 'dropdown',
                'default'     => 'all',
                'options'     => [
                    'all'   => 'sublimearts.dealers::lang.session.all',
                    'user'  => 'sublimearts.dealers::lang.session.users',
                    'guest' => 'sublimearts.dealers::lang.session.guests'
                ]
            ],
            'redirect' => [
                'title'       => 'sublimearts.dealers::lang.session.redirect_title',
                'description' => 'sublimearts.dealers::lang.session.redirect_desc',
                'type'        => 'dropdown',
                'default'     => ''
            ]
        ];
    }

    public function getRedirectOptions()
    {
        return [''=>'- none -'] + Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * Executed when this component is bound to a page or layout.
     */
    public function onRun()
    {
        $redirectUrl = $this->controller->pageUrl($this->property('redirect'));
        $allowedGroup = $this->property('security', self::ALLOW_ALL);
        $isAuthenticated = Auth::check();

        if (!$isAuthenticated && $allowedGroup == self::ALLOW_DEALER) {
            return Redirect::guest($redirectUrl);
        }
        elseif ($isAuthenticated && $allowedGroup == self::ALLOW_GUEST) {
            return Redirect::guest($redirectUrl);
        }

        $this->page['dealer'] = $this->dealer();
    }

    /**
     * Log out the user
     *
     * Usage:
     *   <a data-request="onLogout">Sign out</a>
     *
     * With the optional redirect parameter:
     *   <a data-request="onLogout" data-request-data="redirect: '/good-bye'">Sign out</a>
     *
     */
    public function onLogout()
    {
        Auth::logout();
        $url = post('redirect', Request::fullUrl());
        Flash::success(Lang::get('sublimearts.dealers::lang.session.logout'));

        return Redirect::to($url);
    }

    /**
     * Returns the logged in user, if available
     */
    public function dealer()
    {
        if (!Auth::check()) {
            return null;
        }

        return Auth::getUser();
    }
}