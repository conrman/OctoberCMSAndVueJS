<?php namespace SublimeArts\Forms\Components;

use Cms\Classes\ComponentBase;
use SublimeArts\Dealers\models\Dealer;
use Log, Flash, Mail, Redirect;

class DealershipRequestForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'DealershipRequestForm Component',
            'description' => 'Allows a user to request becoming a Dealer.'
        ];
    }

    public function onSubmit()
    {
        $company_name = post('company_name');
        $username = post('username');
        $email = post('company_email');
        $country = post('country');
        $state = post('state');
        $city = post('city');
        $phone = post('company_phone');

        $existingDealer = Dealer::where('email', $email)->first();

        if($existingDealer) {
            Flash::warning('Hi, you are already a Dealer with us. Please allow time for activation or use another email, phone and username if needed.');
        } else {
            $dealer = new Dealer;
            $dealer->company_name = $company_name;
            $dealer->username = $username;
            $dealer->email = $email;
            $dealer->country = $country;
            $dealer->state = $state;
            $dealer->city = $city;
            $dealer->phone = $phone;
            $dealer->save();

            if($dealer->save()) {
                Flash::success('Thank You for reaching out to us! We will be in touch shortly');
            } else {
                Flash::error('Ooops! Something went wrong. Please retry or email ashishmodasia@icloud.com');
            }
        }

        return ['#flashmessages' => $this->renderPartial('flash-message')];
    }

}