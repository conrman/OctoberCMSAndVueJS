<?php namespace SublimeArts\Dealers\Controllers;

use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use SublimeArts\Dealers\Models\DealerGroup;

/**
 * User Groups Back-end Controller
 */
class DealerGroups extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['sublimearts.dealers.access_groups'];

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('SublimeArts.Dealers', 'dealers', 'dealergroups');
    }
}