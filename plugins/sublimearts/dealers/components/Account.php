<?php namespace SublimeArts\Dealers\Components;

use Lang;
use Auth;
use Mail;
use Flash;
use Input;
use Request;
use Redirect;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use SublimeArts\Dealers\Models\Settings as DealerSettings;
use Exception;

class Account extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'sublimearts.dealers::lang.account.account',
            'description' => 'sublimearts.dealers::lang.account.account_desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'redirect' => [
                'title'       => 'sublimearts.dealers::lang.account.redirect_to',
                'description' => 'sublimearts.dealers::lang.account.redirect_to_desc',
                'type'        => 'dropdown',
                'default'     => ''
            ],
            'paramCode' => [
                'title'       => 'sublimearts.dealers::lang.account.code_param',
                'description' => 'sublimearts.dealers::lang.account.code_param_desc',
                'type'        => 'string',
                'default'     => 'code'
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
        $routeParameter = $this->property('paramCode');

        /*
         * Activation code supplied
         */
        if ($activationCode = $this->param($routeParameter)) {
            $this->onActivate($activationCode);
        }

        $this->page['dealer'] = $this->dealer();
        $this->page['loginAttribute'] = $this->loginAttribute();
        $this->page['loginAttributeLabel'] = $this->loginAttributeLabel();
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

    /**
     * Returns the login model attribute.
     */
    public function loginAttribute()
    {
        return DealerSettings::get('login_attribute', DealerSettings::LOGIN_EMAIL);
    }

    /**
     * Returns the login label as a word.
     */
    public function loginAttributeLabel()
    {
        return $this->loginAttribute() == DealerSettings::LOGIN_EMAIL
            ? Lang::get('sublimearts.dealers::lang.login.attribute_email')
            : Lang::get('sublimearts.dealers::lang.login.attribute_username');
    }

    /**
     * Sign in the user
     */
    public function onSignin()
    {
        /*
         * Validate input
         */
        $data = post();
        $rules = [];

        $rules['login'] = $this->loginAttribute() == DealerSettings::LOGIN_USERNAME
            ? 'required|between:2,255'
            : 'required|email|between:6,255';

        $rules['password'] = 'required|between:4,255';

        if (!array_key_exists('login', $data)) {
            $data['login'] = post('username', post('email'));
        }

        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        /*
         * Authenticate user
         */
        $dealer = Auth::authenticate([
            'login'    => array_get($data, 'login'),
            'password' => array_get($data, 'password')
        ], true);

        /*
         * Redirect to the intended page after successful sign in
         */
        $redirectUrl = $this->pageUrl($this->property('redirect'))
            ?: $this->property('redirect');

        if ($redirectUrl = input('redirect', $redirectUrl)) {
            return Redirect::intended($redirectUrl);
        }
    }

    /**
     * Register the user
     */
    public function onRegister()
    {
        try {
            if (!DealerSettings::get('allow_registration', true)) {
                throw new ApplicationException(Lang::get('sublimearts.dealers::lang.account.registration_disabled'));
            }

            /*
             * Validate input
             */
            $data = post();

            if (!array_key_exists('password_confirmation', $data)) {
                $data['password_confirmation'] = post('password');
            }

            $rules = [
                'email'    => 'required|email|between:6,255',
                'password' => 'required|between:4,255'
            ];

            if ($this->loginAttribute() == DealerSettings::LOGIN_USERNAME) {
                $rules['username'] = 'required|between:2,255';
            }

            $validation = Validator::make($data, $rules);
            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            /*
             * Register user
             */
            $requireActivation = DealerSettings::get('require_activation', true);
            $automaticActivation = DealerSettings::get('activate_mode') == DealerSettings::ACTIVATE_AUTO;
            $dealerActivation = DealerSettings::get('activate_mode') == DealerSettings::ACTIVATE_USER;
            $dealer = Auth::register($data, $automaticActivation);

            /*
             * Activation is by the user, send the email
             */
            if ($dealerActivation) {
                $this->sendActivationEmail($dealer);

                Flash::success(Lang::get('sublimearts.dealers::lang.account.activation_email_sent'));
            }

            /*
             * Automatically activated or not required, log the user in
             */
            if ($automaticActivation || !$requireActivation) {
                Auth::login($dealer);
            }

            /*
             * Redirect to the intended page after successful sign in
             */
            $redirectUrl = $this->pageUrl($this->property('redirect'))
                ?: $this->property('redirect');

            if ($redirectUrl = post('redirect', $redirectUrl)) {
                return Redirect::intended($redirectUrl);
            }

        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    /**
     * Activate the user
     * @param  string $code Activation code
     */
    public function onActivate($code = null)
    {
        try {
            $code = post('code', $code);

            /*
             * Break up the code parts
             */
            $parts = explode('!', $code);
            if (count($parts) != 2) {
                throw new ValidationException(['code' => Lang::get('sublimearts.dealers::lang.account.invalid_activation_code')]);
            }

            list($dealerId, $code) = $parts;

            if (!strlen(trim($dealerId)) || !($dealer = Auth::findUserById($dealerId))) {
                throw new ApplicationException(Lang::get('sublimearts.dealers::lang.account.invalid_user'));
            }

            if (!$dealer->attemptActivation($code)) {
                throw new ValidationException(['code' => Lang::get('sublimearts.dealers::lang.account.invalid_activation_code')]);
            }

            Flash::success(Lang::get('sublimearts.dealers::lang.account.success_activation'));

            /*
             * Sign in the user
             */
            Auth::login($dealer);

        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }
    }

    /**
     * Update the user
     */
    public function onUpdate()
    {
        if (!$dealer = $this->dealer()) {
            return;
        }

        $dealer->fill(post());
        $dealer->save();

        /*
         * Password has changed, reauthenticate the user
         */
        if (strlen(post('password'))) {
            Auth::login($dealer->reload(), true);
        }

        Flash::success(post('flash', Lang::get('sublimearts.dealers::lang.account.success_saved')));

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    /**
     * Deactivate user
     */
    public function onDeactivate()
    {
        if (!$dealer = $this->user()) {
            return;
        }

        if (!$dealer->checkHashValue('password', post('password'))) {
            throw new ValidationException(['password' => Lang::get('sublimearts.dealers::lang.account.invalid_deactivation_pass')]);
        }

        $dealer->delete();
        Auth::logout();

        Flash::success(post('flash', Lang::get('sublimearts.dealers::lang.account.success_deactivation')));

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    /**
     * Trigger a subsequent activation email
     */
    public function onSendActivationEmail()
    {
        try {
            if (!$dealer = $this->user()) {
                throw new ApplicationException(Lang::get('sublimearts.dealers::lang.account.login_first'));
            }

            if ($dealer->is_activated) {
                throw new ApplicationException(Lang::get('sublimearts.dealers::lang.account.already_active'));
            }

            Flash::success(Lang::get('sublimearts.dealers::lang.account.activation_email_sent'));

            $this->sendActivationEmail($dealer);

        }
        catch (Exception $ex) {
            if (Request::ajax()) throw $ex;
            else Flash::error($ex->getMessage());
        }

        /*
         * Redirect
         */
        if ($redirect = $this->makeRedirection()) {
            return $redirect;
        }
    }

    /**
     * Sends the activation email to a user
     * @param  User $dealer
     * @return void
     */
    protected function sendActivationEmail($dealer)
    {
        $code = implode('!', [$dealer->id, $dealer->getActivationCode()]);
        $link = $this->currentPageUrl([
            $this->property('paramCode') => $code
        ]);

        $data = [
            'name' => $dealer->company_name,
            'link' => $link,
            'code' => $code
        ];

        Mail::send('sublimearts.dealers::mail.activate', $data, function($message) use ($dealer) {
            $message->to($dealer->email, $dealer->company_name);
        });
    }

    /**
     * Redirect to the intended page after successful update, sign in or registration.
     * The URL can come from the "redirect" property or the "redirect" postback value.
     * @return mixed
     */
    protected function makeRedirection()
    {
        $redirectUrl = $this->pageUrl($this->property('redirect'))
            ?: $this->property('redirect');

        if ($redirectUrl = post('redirect', $redirectUrl)) {
            return Redirect::to($redirectUrl);
        }
    }
}
