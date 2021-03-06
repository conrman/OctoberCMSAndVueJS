<?php namespace SublimeArts\DealerStore\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SublimeArts\DealerStore\Models\LineItem;

/**
 * Orders Back-end Controller
 */
class Orders extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('SublimeArts.DealerStore', 'dealerstore', 'orders');
    }
}