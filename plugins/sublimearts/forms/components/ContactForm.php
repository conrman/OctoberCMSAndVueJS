<?php namespace SublimeArts\Forms\Components;

use Cms\Classes\ComponentBase;
use Log, Flash, Mail, Redirect;
use SublimeArts\Forms\Models\Lead;

class ContactForm extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'Contact Form',
            'description' => 'Provides a full contact form.'
        ];
    }

    public function onSubmit()
    {
        $email = post('email');
        $fullname = post('fullname');
        $message = post('message');
        $queryType = post('query-type');
        
        $leadExists = Lead::where('email', $email)->first();
        
        if($leadExists) {
            Flash::warning('We have already have a message pending from you. If you need further assistance please email ashishmodasia@icloud.com!');
        } else {
            $lead = new Lead;
            $lead->email = $email;
            $lead->fullname = $fullname;
            $lead->message = $message;
            $lead->type = $queryType;
            $lead->save();

            if($lead->save()) {
                Flash::success('Thank You for reaching out to us! We will be in touch shortly');
            } else {
                Flash::error('Ooops! Something went wrong. Please retry or email ashishmodasia@icloud.com');
            }
        }

        return ['#flashmessages' => $this->renderPartial('flash-message')];
    }

}