<?php namespace SublimeArts\Forms\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Leads Back-end Controller
 */
class Leads extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('SublimeArts.Forms', 'forms', 'leads');
    }
}