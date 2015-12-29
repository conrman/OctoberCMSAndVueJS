<?php namespace SublimeArts\Dealers\Components;

use Auth;
use Mail;
use Validator;
use ValidationException;
use ApplicationException;
use Cms\Classes\ComponentBase;
use SublimeArts\Dealers\Models\Dealers as DealerModel;

class ResetPassword extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name'        => 'sublimearts.dealers::lang.reset_password.reset_password',
            'description' => 'sublimearts.dealers::lang.reset_password.reset_password_desc'
        ];
    }

    public function defineProperties()
    {
        return [
            'paramCode' => [
                'title'       => 'sublimearts.dealers::lang.reset_password.code_param',
                'description' => 'sublimearts.dealers::lang.reset_password.code_param_desc',
                'type'        => 'string',
                'default'     => 'code'
            ]
        ];
    }

    /**
     * Trigger the password reset email
     */
    public function onRestorePassword()
    {
        $rules = [
            'email' => 'required|email|between:6,255'
        ];

        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        if (!$dealer = DealerModel::findByEmail(post('email'))) {
            throw new ApplicationException(trans('sublimearts.dealers::lang.account.invalid_user'));
        }

        $code = implode('!', [$dealer->id, $dealer->getResetPasswordCode()]);
        $link = $this->controller->currentPageUrl([
            $this->property('paramCode') => $code
        ]);

        $data = [
            'name' => $dealer->company_name,
            'link' => $link,
            'code' => $code
        ];

        Mail::send('sublimearts.dealers::mail.restore', $data, function($message) use ($dealer) {
            $message->to($dealer->email, $dealer->company_name);
        });
    }

    /**
     * Perform the password reset
     */
    public function onResetPassword()
    {
        $rules = [
            'code'     => 'required',
            'password' => 'required|between:4,255'
        ];

        $validation = Validator::make(post(), $rules);
        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        /*
         * Break up the code parts
         */
        $parts = explode('!', post('code'));
        if (count($parts) != 2) {
            throw new ValidationException(['code' => trans('sublimearts.dealers::lang.account.invalid_activation_code')]);
        }

        list($dealerId, $code) = $parts;

        if (!strlen(trim($dealerId)) || !($dealer = Auth::findUserById($dealerId))) {
            throw new ApplicationException(trans('sublimearts.dealers::lang.account.invalid_user'));
        }

        if (!$dealer->attemptResetPassword($code, post('password'))) {
            throw new ValidationException(['code' => trans('sublimearts.dealers::lang.account.invalid_activation_code')]);
        }
    }

    /**
     * Returns the reset password code from the URL
     * @return string
     */
    public function code()
    {
        $routeParameter = $this->property('paramCode');

        return $this->param($routeParameter);
    }
}